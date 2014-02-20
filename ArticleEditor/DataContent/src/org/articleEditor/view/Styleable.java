package org.articleEditor.view;

import java.text.AttributedCharacterIterator;
import java.text.AttributedString;

/**
 * Interface to style a component.
 *
 * @see AttributedCharacterIterator
 * @author Anthony Goubard - Japplis
 */
public interface Styleable {

    /**
     * Overrides the font attributes with the given attributes.
     */
    void setFontAttributes(AttributedString attributes);
    public void selected(int x, int y);

    /**
     * Gets the font attributes that are on the selection.
     * If in the selection an attribute has different values (e.g. font size), the attribute is not returned.
     * @return
     */
    AttributedString getCommonFontAttributes();

}
