/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package org.articleEditor.insertContent;

import java.awt.BorderLayout;
import java.awt.Component;
import java.awt.Dimension;
import java.awt.GraphicsEnvironment;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.beans.PropertyChangeEvent;
import java.beans.PropertyChangeListener;
import java.io.File;
import java.io.IOException;
import java.lang.reflect.Constructor;
import java.lang.reflect.InvocationTargetException;
import java.util.List;
import java.util.Properties;
import javax.swing.Action;
import javax.swing.JButton;
import javax.swing.JComponent;
import javax.swing.JOptionPane;
import javax.swing.JScrollPane;
import javax.swing.JTabbedPane;
import javax.swing.JTextPane;
import javax.swing.JToolBar;
import javax.swing.SwingUtilities;
import javax.swing.SwingWorker;
import org.jdesktop.swingx.scrollpaneselector.ScrollPaneSelector;
import org.netbeans.api.progress.ProgressHandle;
import org.netbeans.api.progress.ProgressHandleFactory;
import org.openide.awt.Toolbar;
import org.openide.awt.UndoRedo;
import org.openide.cookies.CloseCookie;
import org.openide.explorer.ExplorerManager;
import org.openide.explorer.ExplorerUtils;
import org.openide.filesystems.FileObject;
import org.openide.filesystems.FileUtil;
import org.openide.loaders.DataObject;
import org.openide.loaders.DataObjectNotFoundException;
import org.openide.util.Exceptions;
import org.openide.util.Lookup;
import org.openide.util.NbBundle.Messages;
import org.openide.util.RequestProcessor;
import org.openide.util.Utilities;
import org.openide.util.actions.Presenter;
import org.openide.util.lookup.AbstractLookup;
import org.openide.util.lookup.InstanceContent;
import org.openide.util.lookup.Lookups;
import org.openide.util.lookup.ProxyLookup;
import org.openide.windows.CloneableTopComponent;
import org.openide.windows.TopComponent;
import org.openide.windows.WindowManager;

/**
 *
 * @author Lenovo
 */
public abstract class ArticleTopComponent extends CloneableTopComponent {
    
    private InstanceContent services;
    private JComponent mainComponent;
    private UndoRedo.Manager manager = new UndoRedo.Manager();
    
    public ArticleTopComponent(){
    }
    
    public ArticleTopComponent( ArticleDataObject dataObject)  {
            init(dataObject);            
        }

    protected void init(ArticleDataObject dataObject) {
       
        services = new InstanceContent();
        Lookup actionsLookup = ExplorerUtils.createLookup(new ExplorerManager(), getActionMap());
        Lookup lookup = new ProxyLookup(actionsLookup,dataObject.getLookup(), new AbstractLookup(services));
        associateLookup(lookup);

        initComponents();
        FileObject documentFileObject = dataObject.getPrimaryFile();
        String fileDisplayName = FileUtil.getFileDisplayName(documentFileObject);
        setToolTipText(fileDisplayName);
        setName(documentFileObject.getName());
        loadDocument(documentFileObject);    
    }

    private void initComponents() {
        setLayout(new BorderLayout());
        JToolBar topToolbar = createToolbar();
        mainComponent = createMainComponent();
        if (mainComponent instanceof JScrollPane || mainComponent instanceof JTabbedPane) {
            add(mainComponent);
        } else {
            JScrollPane mainPane = new JScrollPane(mainComponent);
            mainPane.getVerticalScrollBar().setUnitIncrement(16);
            ScrollPaneSelector.installScrollPaneSelector(mainPane);
            //JLayer<Component> zoomLayer = new JLayer<>(mainPane.getViewport().getView(), new ZoomLayerUI());
            //mainPane.getViewport().setView(zoomLayer);
            add(mainPane);  
            mainComponent.setSize(545, Integer.MAX_VALUE);
            mainComponent.setPreferredSize(new Dimension(545, Integer.MAX_VALUE));
            mainComponent.setMaximumSize(new Dimension(545, Integer.MAX_VALUE));
            setBounds(GraphicsEnvironment.getLocalGraphicsEnvironment().getMaximumWindowBounds());                        
        }

        add(topToolbar, BorderLayout.NORTH);
    }

    protected JToolBar createToolbar() {
        JToolBar toolbar = new Toolbar(getShortName());
        String toolbarActionsPath = "Office/" + getShortName() + "/Toolbar";
        List<? extends Action> toolbarActions = Utilities.actionsForPath(toolbarActionsPath);
        for (Action action : toolbarActions) {
            if (action == null) {
                toolbar.addSeparator();
            } else if (action instanceof Presenter.Toolbar) {
                Component actionComponent = ((Presenter.Toolbar) action).getToolbarPresenter();
                toolbar.add(actionComponent);
            } else {
                JButton newButton = toolbar.add(action);
                if (newButton.getToolTipText() == null) {
                    String label = (String) action.getValue("displayName");
                    newButton.setToolTipText(label);
                }
            }
        }
        return toolbar;
    }
        
    protected abstract JComponent createMainComponent();

    public JComponent getMainComponent() {
        return mainComponent;
    }
    
    protected abstract Object loadDocument(File documentFile) throws Exception;
    
    @Messages({"# {0} - file name", "MSG_Opening=Opening {0}"})
    private void loadDocument(FileObject documentFileObject) {
        final File documentFile = FileUtil.toFile(documentFileObject);
        // String openingTitle = NbBundle.getMessage(getClass(), "MSG_Opening", documentFile.getName());
        final ProgressHandle progress = ProgressHandleFactory.createHandle("Opening " + documentFile.getName());
        progress.start();
        SwingWorker loader = new DocumentLoader(documentFile, progress);        
        RequestProcessor requestProcessor = new RequestProcessor(getClass());
        requestProcessor.post(loader);                     
    }
    
    public ArticleDataObject getDataObject() {
        ArticleDataObject dataObject = getLookup().lookup(ArticleDataObject.class);      
        return dataObject;
    }
    
    //Sin implementación
    protected void documentLoaded() {
    }
    
    public InstanceContent getServices() {
        return services;
    }
    
    public static <T> T getSelectedComponent(Class<T> expectedTopComponent) {
        
        TopComponent selected = TopComponent.getRegistry().getActivated();
        if (selected.getClass().isAssignableFrom(expectedTopComponent)) {
            return (T) selected;
        } else {
            return null;
        }
    }

     @Override
    protected CloneableTopComponent createClonedObject() {
        try {
            // Use reflection
            Constructor componentContructor = getClass().getConstructor(ArticleDataObject.class);
            Object newComponent = componentContructor.newInstance(getDataObject());            
            return (CloneableTopComponent) newComponent;
        } catch (NoSuchMethodException | SecurityException | InstantiationException | IllegalAccessException | InvocationTargetException ex) {
            Exceptions.printStackTrace(ex);
        }
        return null;
        
    }
     @Override
    protected boolean closeLast() {
        ArticleDataObject dataObject = getDataObject();
        int answer = OfficeUIUtils.checkSaveBeforeClosing(dataObject, this);
        boolean canClose = answer == JOptionPane.YES_OPTION || answer == JOptionPane.NO_OPTION;
        if (canClose && dataObject != null) {
            dataObject.setModified(false);
        }
        return canClose;
    }


    @Override
    public UndoRedo getUndoRedo() {
        return manager;
    }

    public void writeProperties(Properties properties) {
        properties.setProperty("version", "1.0");
        File closingFile = FileUtil.toFile(getDataObject().getPrimaryFile());
        properties.setProperty("path", closingFile.getAbsolutePath());
    }

    public void readProperties(Properties properties) throws IOException {
        String version = properties.getProperty("version");
        try {
            String path = properties.getProperty("path");
            File openingFile = FileUtil.normalizeFile(new File(path));
            FileObject openingFileObject = FileUtil.toFileObject(openingFile);
            ArticleDataObject openingDataObject = (ArticleDataObject) DataObject.find(openingFileObject);            
            init(openingDataObject); 

            // If the file has moved or has been deleted
        } catch (DataObjectNotFoundException ex) {
            close();
        }
    }

    private class ChangeTitleIfModified implements PropertyChangeListener {

        @Override
        public void propertyChange(PropertyChangeEvent evt) {            
            if (evt.getPropertyName().equals(DataObject.PROP_MODIFIED)) {
                final boolean modified = (Boolean) evt.getNewValue();
                SwingUtilities.invokeLater(new Runnable() {

                    @Override
                    public void run() {
                        if (modified) {
                            setHtmlDisplayName("<html><body><b>" + getDataObject().getName());
                        } else {
                            setHtmlDisplayName("<html><body>" + getDataObject().getName());
                        }
                    }
                });
            }
        }
    }
    
    
    class DocumentLoader extends SwingWorker {

        private boolean successful;
        private File documentFile;
        private ProgressHandle progress;

        DocumentLoader(File documentFile, ProgressHandle progress) {
            this.documentFile = documentFile;
            this.progress = progress;
        }

        @Override
        protected Object doInBackground() throws Exception {
            try {
                Object document = loadDocument(documentFile);
                getDataObject().setDocument(document);
                successful = true;                
                return document;
            } catch (Exception ex) {
                Exceptions.printStackTrace(ex);
                throw ex;
            }
        }

        @Override
        protected void done() {
            if (successful) {
                documentLoaded();
            } else {
                getDataObject().getLookup().lookup(CloseCookie.class).close();
            }
            progress.finish();          
            getDataObject().addPropertyChangeListener(new ChangeTitleIfModified());
        }
    } 
    
}
