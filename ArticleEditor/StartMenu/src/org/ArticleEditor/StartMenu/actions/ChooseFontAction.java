/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

package org.ArticleEditor.StartMenu.actions;

import java.awt.event.ActionEvent;
import java.awt.font.TextAttribute;
import java.text.AttributedString;
import javax.swing.AbstractAction;
import org.ArticleEditor.StartMenu.ui.FontListTopComponent;
import org.articleEditor.view.Styleable;

import org.openide.DialogDescriptor;
import org.openide.DialogDisplayer;

import org.openide.awt.ActionID;
import org.openide.awt.ActionReference;
import org.openide.awt.ActionReferences;
import org.openide.awt.ActionRegistration;
import org.openide.util.NbBundle;
import org.openide.util.NbBundle.Messages;

/**
 * Change font.
 *
 * 
 */

public class ChooseFontAction extends AbstractAction {

    private Styleable styleable;

    public ChooseFontAction(Styleable styleable) {
        this.styleable = styleable;
    }

    @Override
    public void actionPerformed(ActionEvent ae) {
        AttributedString attributes = new AttributedString("ChangeFont");
        String fontName = ae.getActionCommand();
        if (fontName == null || fontName.isEmpty()) {
            FontListTopComponent fontList = new FontListTopComponent();
            fontList.noSelectionListener();
            String selectFontTitle = NbBundle.getMessage(getClass(), "MSG_SelectFontTitle");
            DialogDescriptor dialogDesc = new DialogDescriptor(fontList, selectFontTitle);
            Object dialogResult = DialogDisplayer.getDefault().notify(dialogDesc);
            if (dialogResult == DialogDescriptor.OK_OPTION) {
                fontName = fontList.getSelectedFontName();
            }
        }
        if (fontName != null) {
            attributes.addAttribute(TextAttribute.FAMILY, fontName);
            styleable.setFontAttributes(attributes);
        }
    }
}
