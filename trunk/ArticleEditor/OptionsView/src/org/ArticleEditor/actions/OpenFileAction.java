/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package org.ArticleEditor.actions;

import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.io.File;
import java.io.IOException;
import org.openide.awt.ActionID;
import org.openide.awt.ActionReference;
import org.openide.awt.ActionRegistration;
import org.openide.cookies.OpenCookie;
import org.openide.filesystems.FileChooserBuilder;
import org.openide.filesystems.FileObject;
import org.openide.filesystems.FileUtil;
import org.openide.loaders.DataObject;
import org.openide.loaders.DataObjectNotFoundException;
import org.openide.util.Exceptions;
import org.openide.util.NbBundle.Messages;

@ActionID(
        category = "File",
        id = "org.ArticleEditor.actions.OpenFileAction")
@ActionRegistration(
        displayName = "#CTL_OpenFileAction")
@ActionReference(path = "Menu/File", position = 1300)
@Messages("CTL_OpenFileAction=Open File")
public final class OpenFileAction implements ActionListener {

    @Override
    public void actionPerformed(ActionEvent e) {
         File fileDocx = new File(System.getProperty("user.home")); 
        File toAdd = new FileChooserBuilder("user-dir").setTitle("Open File").setDefaultWorkingDirectory(fileDocx).setApproveText("Open").showOpenDialog();       
        
        if(toAdd != null){
           try{               
               DataObject.find(FileUtil.toFileObject(toAdd)).getCookie(OpenCookie.class).open();// .getLookup().lookup(OpenCookie.class).open();                      
               //MenuLeftTopComponent menu = new MenuLeftTopComponent(DataObject.find(FileUtil.toFileObject(toAdd)));
                
               //WordprocessingMLPackage wordMLPackage = WordprocessingMLPackage.load(new java.io.File(toAdd.getPath())); 

           }
             catch(DataObjectNotFoundException ex){
                 Exceptions.printStackTrace(ex);
             /*} catch (Docx4JException ex) {
                Exceptions.printStackTrace(ex);*/
            } catch (IOException ex) {
                 Exceptions.printStackTrace(ex);
             }
         }
    }
}
