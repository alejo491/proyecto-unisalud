/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package org.ArticleEditor.DataContent;

import java.awt.Component;
import org.articleEditor.insertContent.ArticleTopComponent;
import java.awt.Dimension;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.util.Collection;
import javax.swing.ActionMap;
import javax.swing.JComponent;
import javax.swing.JTextPane;
import javax.swing.event.DocumentEvent;
import javax.swing.event.DocumentListener;
import javax.swing.text.BadLocationException;
import javax.swing.text.DefaultEditorKit;
import javax.swing.text.Document; 
import org.apache.poi.xwpf.usermodel.XWPFDocument;
import org.articleEditor.articleKit.DocxEditorKit;
import org.articleEditor.insertContent.ArticleDataObject;
import org.articleEditor.insertContent.DocumentUpdater1;
import org.articleEditor.insertContent.RichTextTransferHandler;
import org.articleEditor.insertContent.TextUndoManager;
import org.articleEditor.view.EditorStyleable;
import org.netbeans.api.settings.ConvertAsProperties;
import org.openide.awt.ActionID;
import org.openide.awt.UndoRedo;
import org.openide.loaders.DataObject;
import org.openide.util.Lookup;
import org.openide.util.NbBundle;
import org.openide.util.lookup.ServiceProvider;
import org.openide.windows.CloneableTopComponent;
import org.openide.windows.TopComponent;

/**
 *
 * @author Lenovo
 */
@ConvertAsProperties(
        dtd = "-//org.editorArticulos.insertContent//ArticleEditor//EN",
        autostore = false)
@TopComponent.Description(
        preferredID = "ArticleProcessorTopComponent",
        //iconBase="SET/PATH/TO/ICON/HERE", 
        persistenceType = TopComponent.PERSISTENCE_ONLY_OPENED)
@TopComponent.Registration(mode = "editor", openAtStartup = false)
@ActionID(category = "Window", id = "org.editorArticulos.insertContent.ArticleEditorTopComponent")
//@ActionReference(path = "Menu/Window" /*, position = 333 */)
@TopComponent.OpenActionRegistration(
        displayName = "#CTL_ArticleEditorAction",
        preferredID = "ArticleEditorTopComponent")
@ServiceProvider (service = ArticleTopComponent.class) 
@NbBundle.Messages({
    "CTL_ArticleEditorAction=ArticleEditor",
    "CTL_ArticleEditorTopComponent=ArticleEditor Window",
    "HINT_ArticleEditorTopComponent=This is a ArticleEditor window"
})
public final class ArticleEditorTopComponent extends ArticleTopComponent implements DocumentListener {
    
    private TextUndoManager undoRedo = new TextUndoManager();
    private EditorStyleable styleable;

    public ArticleEditorTopComponent(){
    }
    
    public ArticleEditorTopComponent(ArticleDataObject dataObject){
        super(dataObject);
    }
                
    @Override
    public void writeProperties(java.util.Properties p) {
        super.writeProperties(p);
    }

    @Override
    public void readProperties(java.util.Properties p) throws IOException {
        super.readProperties(p);
        System.out.println("###### --- Read Properties ArticleEditor!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!.....");
    }
   
   @Override
    protected JComponent createMainComponent() {
        JTextPane editor = new JTextPane();
        editor.setEditorKit(new DocxEditorKit());
        editor.setTransferHandler(new RichTextTransferHandler());
        styleable = new EditorStyleable(editor);     
        editor.putClientProperty("print.printable", Boolean.TRUE);         
        
        // Doesn't work
        editor.setSize(new Dimension(545, Integer.MAX_VALUE));
        editor.setPreferredSize(new Dimension(545, Integer.MAX_VALUE));
        editor.setMaximumSize(new Dimension(545, Integer.MAX_VALUE));                
        return editor;
        
    }
     
    
    @Override
    public String getShortName() {
        return "Word Processor";
    }

    @Override
    public Object loadDocument(final File docxFile) throws Exception {
        try (FileInputStream docxIS = new FileInputStream(docxFile)) {
            JTextPane wordProcessor = (JTextPane) getMainComponent();            
            wordProcessor.getEditorKit().read(docxIS, wordProcessor.getDocument(), 0);            
            XWPFDocument poiDocument = (XWPFDocument) wordProcessor.getDocument().getProperty("XWPFDocument");
            
            System.out.println("ANCHO Y ALTO loadDocument: "+ wordProcessor.getWidth()+" - "+wordProcessor.getHeight());
            /*wordProcessor.setCaretPosition(1);
            wordProcessor.getCaret().setVisible(true);             
*/
            System.out.println("###########loadDocument  ARTICLE EDITOR!!!!...");
            return poiDocument;
        } catch (IOException | BadLocationException ex) {
            throw ex;
        }
    }
    
    
     @Override
     public void documentLoaded() {
        JTextPane editor = ((JTextPane) getMainComponent());
        Document document = editor.getDocument();
        document.addDocumentListener(this);
        document.addUndoableEditListener(undoRedo);
        document.addDocumentListener( new DocumentUpdater1(getPOIDocument())); 
        System.out.println("ANCHO Y ALTO documentLoaded(): "+ editor.getWidth()+" - "+editor.getHeight());
        
        // Doesn't do anything (yet)
        // This require the implementation of a TokenListProvider and of a TokenList
        // Spellchecker.register(editor);
        /*FindAction find = new FindAction();
         getActionMap().put(find.getName(), find);
         ReplaceAction replace = new ReplaceAction();
         getActionMap().put(replace.getName(), replace);*/
    }
     
    public XWPFDocument getPOIDocument() {
        return (XWPFDocument) getDataObject().getDocument();
    }
      
    @Override
    protected void componentActivated() {
        JTextPane wordProcessor = (JTextPane) getMainComponent();
        ActionMap editorActionMap = wordProcessor.getActionMap();
        getActionMap().put(DefaultEditorKit.cutAction, editorActionMap.get(DefaultEditorKit.cutAction));
        getActionMap().put(DefaultEditorKit.copyAction, editorActionMap.get(DefaultEditorKit.copyAction));
        getActionMap().put(DefaultEditorKit.pasteAction, editorActionMap.get(DefaultEditorKit.pasteAction));
        getServices().add(styleable);
        wordProcessor.setSize(WIDTH, WIDTH);
        super.componentActivated();
        System.out.println("Width!!! ...... "+this.getSize());
        System.out.println("Height!!!.... "+ this.getHeight());
        
        
    }

    @Override
    protected void componentDeactivated() {
        getServices().remove(styleable);        
        super.componentDeactivated();
    }
    
    @Override
    public UndoRedo getUndoRedo() {
        return undoRedo;
    }
    
    public static JTextPane findCurrentTextPane() {
        ArticleEditorTopComponent wordProcessor = ArticleTopComponent.getSelectedComponent(ArticleEditorTopComponent.class);
        return (JTextPane) wordProcessor.getMainComponent();
    }   

    @Override
    public void insertUpdate(DocumentEvent de) {
        getDataObject().setModified(true);
    }

    @Override
    public void removeUpdate(DocumentEvent de) {
        getDataObject().setModified(true);
    }

    @Override
    public void changedUpdate(DocumentEvent de) {
        getDataObject().setModified(true);
    }


    
}
