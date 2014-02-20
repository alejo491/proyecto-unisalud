/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package org.articleEditor.insertContent;

import org.articleEditor.insertContent.ArticleTopComponent;
import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.OutputStream;
import java.nio.file.Files;
import java.nio.file.StandardCopyOption;
import org.openide.cookies.CloseCookie;
import org.openide.cookies.EditCookie;
import org.openide.cookies.EditorCookie;
import org.openide.cookies.OpenCookie;
import org.openide.cookies.SaveCookie;
import org.openide.cookies.ViewCookie;
import org.openide.filesystems.FileObject;
import org.openide.filesystems.FileUtil;
import org.openide.loaders.DataNode;
import org.openide.loaders.DataObjectExistsException;
import org.openide.loaders.MultiDataObject;
import org.openide.loaders.MultiFileLoader;
import org.openide.loaders.OpenSupport;
import org.openide.loaders.SaveAsCapable;
import org.openide.nodes.Children;
import org.openide.nodes.CookieSet;
import org.openide.nodes.Node;
import org.openide.util.Lookup;
import org.openide.windows.CloneableTopComponent;

/**
 *
 * @author Lenovo
 */
public abstract class ArticleDataObject extends MultiDataObject implements SaveCookie, SaveAsCapable, CookieSet.Factory{
    
    private Object document;
    private ArticleOpenSupport opener;
    
    //Constructor de la Clase ArticleDataObject
    public ArticleDataObject(FileObject pf, MultiFileLoader loader) throws DataObjectExistsException {
        super(pf, loader);
        CookieSet cookies = getCookieSet();
        cookies.add(ArticleOpenSupport.class, this);
        cookies.add(SaveCookie.class, this);
        cookies.assign(SaveAsCapable.class, this);
    
    }
    
    public void setDocument(Object document) {
        this.document = document;
    }

    public Object getDocument() {
        return document;
    }

    @Override
    public void setModified(boolean modified) {
        super.setModified(modified);
        if (modified) {
            getCookieSet().add(this);
        } else {
            getCookieSet().remove(this);
        }
    }

    @Override
    protected Node createNodeDelegate() {
        return new DataNode(this, Children.LEAF, getLookup());
    }

    @Override
    public Lookup getLookup() {
        return getCookieSet().getLookup();
    }

    @Override
    public <T extends Node.Cookie> T createCookie(Class<T> type) {
        if (type.isAssignableFrom(ArticleOpenSupport.class)) {
            if (opener == null) {
                opener = new ArticleOpenSupport(getPrimaryEntry());
            }
            return (T) opener;
        }
        if (type.isAssignableFrom(SaveCookie.class)) {
            return (T) this;
        }
        return null;
    }

    @Override
    protected int associateLookup() {
        return 1;
    }

    @Override
    public synchronized void save() throws IOException {
        File currentFile = FileUtil.toFile(getPrimaryFile());
        File backup = backupOriginal(currentFile);
        File secureSave = new File(currentFile.getAbsolutePath() + ".new." + getPrimaryFile().getExt());
        save(secureSave);
        if (secureSave.exists() && secureSave.length() > 0) {
            try (OutputStream currentFileStream = new FileOutputStream(currentFile)) {
                Files.copy(secureSave.toPath(), currentFileStream);
            }
            boolean deleted = backup.delete();
            boolean newDeleted = secureSave.delete();
        }
        setModified(false);
    }

    private synchronized File backupOriginal(File currentFile) throws IOException {
        File backupFile = new File(currentFile.getAbsolutePath() + ".backup." + getPrimaryFile().getExt());
        if (!backupFile.exists() && currentFile.length() > 0) {
            Files.copy(currentFile.toPath(), backupFile.toPath(), StandardCopyOption.COPY_ATTRIBUTES);
        }
        return backupFile;
    }

    @Override
    public void saveAs(FileObject folder, String fileName) throws IOException {
        FileObject newFile = folder.getFileObject(fileName);
        if (newFile == null) {
            newFile = folder.createData(fileName);
        }
        save(FileUtil.toFile(newFile));
    }
    
    public abstract ArticleTopComponent open(ArticleDataObject dataObject);

    public abstract void save(File file) throws IOException;
    
    private class ArticleOpenSupport extends OpenSupport implements OpenCookie, CloseCookie, ViewCookie {

        private ArticleOpenSupport(MultiDataObject.Entry entry) {
            super(entry);
        }

        @Override
        protected CloneableTopComponent createCloneableTopComponent() {
            ArticleDataObject dataObject = (ArticleDataObject) entry.getDataObject();            
            return ArticleDataObject.this.open(dataObject);
        }   
    }   
}