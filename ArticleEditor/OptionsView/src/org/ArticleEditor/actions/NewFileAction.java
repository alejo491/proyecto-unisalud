/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package org.ArticleEditor.actions;

import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.util.ArrayList;
import java.util.List;
import javax.swing.AbstractAction;
import javax.swing.JFileChooser;
import javax.swing.JOptionPane;
import javax.swing.filechooser.FileFilter;
import org.articleEditor.insertContent.ArticleDataObject;
import org.openide.DialogDisplayer;
import org.openide.NotifyDescriptor;
import org.openide.awt.ActionID;
import org.openide.awt.ActionReference;
import org.openide.awt.ActionReferences;
import org.openide.awt.ActionRegistration;
import org.openide.cookies.OpenCookie;
import org.openide.filesystems.FileObject;
import org.openide.filesystems.FileUtil;
import org.openide.loaders.DataObject;
import org.openide.loaders.DataObjectNotFoundException;
import org.openide.util.Exceptions;
import org.openide.util.NbBundle;
import org.openide.util.NbBundle.Messages;
import org.openide.util.NbPreferences;
import org.openide.windows.WindowManager;

@ActionID(
        category = "File",
        id = "org.ArticleEditor.actions.NewFileAction")
@ActionRegistration(
        displayName = "#CTL_NewFileAction"       
)
@ActionReferences({
    @ActionReference(path = "Menu/File", position = -10),
    @ActionReference(path = "Shortcuts", name = "D-N")
})
@Messages({"CTL_NewFileAction=New Article",
    "MSG_ChooseExtension=Please choose or provide a file type",
    "CTL_Untitled=Untitled"})
public final class NewFileAction extends AbstractAction {

    @Override
    public void actionPerformed(ActionEvent e) {
        // TODO implement action body
        JFileChooser newFileChooser = createFileChooser();
        int saveResult = newFileChooser.showSaveDialog(WindowManager.getDefault().getMainWindow());
        if (saveResult == JFileChooser.APPROVE_OPTION) {
            File savedFile = getSelectedFile(newFileChooser);
            FileObject template = getFileTemplate(savedFile);
            if (template == null) {
                showChooseExtensionMessage();
                actionPerformed(e);
            } else if (shouldCreateFile(savedFile)) {
                try {
                    FileObject createdFile = createFileFromTemplate(template, savedFile);
                    open(createdFile);
                } catch (IOException ex) {
                    Exceptions.printStackTrace(ex);
                }
            }
        }
    }

    private JFileChooser createFileChooser() {
        JFileChooser newFileChooser = new JFileChooser();
        String defaultLocation = NbPreferences.forModule(NewFileAction.class).get("file.location", System.getProperty("user.home"));
        File currentDir = new File(defaultLocation);
        newFileChooser.setCurrentDirectory(currentDir);
        newFileChooser.setDialogType(JFileChooser.SAVE_DIALOG);
        String defaultName = NbBundle.getMessage(getClass(), "CTL_Untitled");
        newFileChooser.setSelectedFile(new File(currentDir, defaultName + ".docx"));
        addFileFilters(newFileChooser);
        return newFileChooser;
    }

    private void addFileFilters(JFileChooser chooser) {
        List<DataObject> possibleObjects = findDataObject("Templates/Other");
        for (DataObject dataObject : possibleObjects) {
            if (dataObject instanceof ArticleDataObject) {
                FileFilter filter = new OfficeFileFilter(dataObject);
                chooser.addChoosableFileFilter(filter);
            }
        }
        chooser.setAcceptAllFileFilterUsed(true);
    }
    
    public List<DataObject> findDataObject(String key) {
        List<DataObject> templates = new ArrayList<>();
        FileObject fo = FileUtil.getConfigFile(key);
        if (fo != null && fo.isValid()) {
            addFileObject(fo, templates);
        }
        return templates;
    }
    
    private void addFileObject(FileObject fileObject, List<DataObject> templates) {
        if (fileObject.isFolder()) {
            for (FileObject child : fileObject.getChildren()) {
                addFileObject(child, templates);
            }
        } else {
            try {
                DataObject dob = DataObject.find(fileObject);
                templates.add(dob);
            } catch (DataObjectNotFoundException ex) {
                Exceptions.printStackTrace(ex);
            }
        }
    }
    
    public File getSelectedFile(JFileChooser newFileChooser) {
        File savedFile = newFileChooser.getSelectedFile();
        NbPreferences.forModule(NewFileAction.class).put("file.location", savedFile.getParentFile().getAbsolutePath());
        FileFilter filter = newFileChooser.getFileFilter();
        if (!savedFile.getName().contains(".") && filter != null && filter.getDescription().contains(".")) {
            String extension = filter.getDescription().substring(filter.getDescription().indexOf('.'));
            savedFile = new File(savedFile.getAbsolutePath() + extension);
        }
        return savedFile;
    }
    
    @NbBundle.Messages({"MSG_OVERWRITE_FILE=Overwrite existing file?"})
    public boolean shouldCreateFile(File newFile) {

        if (newFile.exists()) {
            String question = NbBundle.getMessage(NewFileAction.class, "MSG_OVERWRITE_FILE");
            int answer = JOptionPane.showConfirmDialog(WindowManager.getDefault().getMainWindow(), question, question, JOptionPane.YES_NO_OPTION, JOptionPane.QUESTION_MESSAGE);
            return answer == JOptionPane.YES_OPTION;
        }
        return true;
    }
    
    public FileObject getFileTemplate(File savedFile) {
        List<DataObject> possibleObjects = findDataObject("Templates/Other");
        for (final DataObject dataObject : possibleObjects) {
            if (dataObject instanceof ArticleDataObject && savedFile.getName().endsWith(dataObject.getPrimaryFile().getExt())) {
                return dataObject.getPrimaryFile();
            }
        }
        return null;
    }

    private void showChooseExtensionMessage() {
        String provideExtensionMessage = NbBundle.getMessage(NewFileAction.class, "MSG_ChooseExtension");
        NotifyDescriptor provideExtensionDialog =
                new NotifyDescriptor.Message(provideExtensionMessage, NotifyDescriptor.INFORMATION_MESSAGE);
        DialogDisplayer.getDefault().notify(provideExtensionDialog);
    }

    public FileObject createFileFromTemplate(FileObject template, File savedFile) throws IOException {
        try (InputStream input = template.getInputStream();
                FileOutputStream output = new FileOutputStream(savedFile);) {
            FileUtil.copy(input, output);
            FileObject savedFileObject = FileUtil.toFileObject(FileUtil.normalizeFile(savedFile));
            return savedFileObject;
        }
    }

    private void open(FileObject fileToOpen) throws DataObjectNotFoundException {
        DataObject fileDataObject = DataObject.find(fileToOpen);
        OpenCookie openCookie = fileDataObject.getCookie(OpenCookie.class);
        if (openCookie != null) {
            openCookie.open();
        }
    }

    private class OfficeFileFilter extends FileFilter {

        private DataObject dataObject;

        private OfficeFileFilter(DataObject dataObject) {
            this.dataObject = dataObject;
        }

        @Override
        public boolean accept(File file) {
            return file.isDirectory() || file.getName().endsWith(dataObject.getPrimaryFile().getExt());
        }

        @Override
        public String getDescription() {
            return "*." + dataObject.getPrimaryFile().getExt();
        }
    }
}
