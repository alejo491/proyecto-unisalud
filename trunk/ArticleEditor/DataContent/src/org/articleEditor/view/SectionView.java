package org.articleEditor.view;

import org.articleEditor.articleKit.DocxDocument;

import javax.swing.text.BoxView;
import javax.swing.text.Element;
import javax.swing.text.View;
import java.awt.*;

/**
 * Represents document root view.
 *
 * @author Stanislav Lapitsky
 */
public class SectionView extends BoxView {
    int pageNumber = 0;
    protected int pageWidth = 930;
    protected int pageHeight = 522;
    public static int DRAW_PAGE_INSET = 15;
    protected Insets pageMargins = new Insets(10, 10, 10, 10);
    /**
     * Constructs a section view.
     *
     * @param elem the element this view is responsible for
     * @param axis either <code>View.X_AXIS</code> or <code>View.Y_AXIS</code>
     */
    public SectionView(Element elem, int axis) {
        super(elem, axis);
    }
    
    public int getPageCount(){
        return pageNumber;
    }

    /**
     * Perform layout on the box
     *
     * @param width the width (inside of the insets) >= 0
     * @param height the height (inside of the insets) >= 0
     */
    @Override
    protected void layout(int width, int height) {
        DocxDocument doc=(DocxDocument)getDocument();
        Insets margins=doc.getDocumentMargins();
        this.setInsets((short)margins.top,(short)margins.left,(short)margins.bottom,(short)margins.right );

        if (doc.DOCUMENT_WIDTH>0) {
            super.layout(doc.DOCUMENT_WIDTH-margins.left-margins.right,height);
        }
        else {           
            int width2 = 850 - 2*DRAW_PAGE_INSET-margins.left-margins.right;
            //pageWidth = width2;
            System.out.println("Section View WIDTH Y HEIGHT: "+width+" - "+width2+" - "+ height);
            this.setInsets( (short) (DRAW_PAGE_INSET + margins.top), (short) (DRAW_PAGE_INSET + margins.left), (short) (DRAW_PAGE_INSET + margins.bottom),(short) (DRAW_PAGE_INSET + margins.right));
            int height2 = 700;
            super.layout(width2,height);
        }
    }
    /**
     * Determines the minimum span for this view along an
     * axis.
     *
     * @param axis may be either View.X_AXIS or View.Y_AXIS
     * @return 
     * @returns  the span the view would like to be rendered into >= 0.
     *           Typically the view is told to render into the span
     *           that is returned, although there is no guarantee.
     *           The parent may choose to resize or break the view.
     * @exception IllegalArgumentException for an invalid axis type
     */
    @Override
    public float getMinimumSpan(int axis) {
        float span  = 0;
        if (axis==View.X_AXIS) {
            DocxDocument doc=(DocxDocument)this.getDocument();
            if (doc.DOCUMENT_WIDTH>0)
                return doc.DOCUMENT_WIDTH;
            else
                return span = pageWidth;
                //return super.getMinimumSpan(axis);
        }
        else {
            span = pageHeight * getPageCount();
            return span;
            //return super.getMinimumSpan(axis);
        }
    }
    /**
     * Determines the maximum span for this view along an
     * axis.
     *
     * @param axis may be either View.X_AXIS or View.Y_AXIS
     * @returns  the span the view would like to be rendered into >= 0.
     *           Typically the view is told to render into the span
     *           that is returned, although there is no guarantee.
     *           The parent may choose to resize or break the view.
     * @exception IllegalArgumentException for an invalid axis type
     */
    @Override
    public float getMaximumSpan(int axis) {
        float span  = 0;
        if (axis==View.X_AXIS) {
            DocxDocument doc=(DocxDocument)this.getDocument();
            if (doc.DOCUMENT_WIDTH>0)
                return doc.DOCUMENT_WIDTH;
            else
                return span = pageWidth;
                //return super.getMinimumSpan(axis);
        }
        else {
            span = pageHeight * getPageCount();
            return span;
            //return super.getMaximumSpan(axis);
        }
    }
    /**
     * Determines the preferred span for this view along an
     * axis.
     *
     * @param axis may be either View.X_AXIS or View.Y_AXIS
     * @returns  the span the view would like to be rendered into >= 0.
     *           Typically the view is told to render into the span
     *           that is returned, although there is no guarantee.
     *           The parent may choose to resize or break the view.
     * @exception IllegalArgumentException for an invalid axis type
     */
    @Override
    public float getPreferredSpan(int axis) {
        float span = 0;
        if (axis==View.X_AXIS) {
            DocxDocument doc=(DocxDocument)this.getDocument();
            if (doc.DOCUMENT_WIDTH>0)
                return doc.DOCUMENT_WIDTH;
            else
                return span = pageWidth;
                //return super.getMinimumSpan(axis);
        }
        else {
            span = pageHeight * getPageCount();
            return span;
            //return super.getMaximumSpan(axis);
        }
    }
    
    /**
         * Performs layout along Y_AXIS with shifts for pages.
         *
         * @param targetSpan int
         * @param axis int
         * @param offsets int[]
         * @param spans int[]
         */
    @Override
    protected void layoutMajorAxis(int targetSpan, int axis, int[] offsets, int[] spans) {
       DocxDocument doc = (DocxDocument) this.getDocument();
       Insets margins=doc.getDocumentMargins();
       super.layoutMajorAxis(targetSpan, axis, offsets, spans);
       int totalOffset = 0;
       int n = offsets.length;
       pageNumber = 0;
       for (int i = 0; i < n; i++) {
           offsets[i] = totalOffset;
           View v = getView(i);
           if (v instanceof MultiPageView) {
               ( (MultiPageView) v).setBreakSpan(0);
               ( (MultiPageView) v).setAdditionalSpace(0);
           }

           if ( (offsets[i] + spans[i]) > (pageNumber * pageHeight - DRAW_PAGE_INSET * 2 - margins.top - margins.bottom)) {
               if ( (v instanceof MultiPageView) && (v.getViewCount() > 1)) {
                   MultiPageView multipageView = (MultiPageView) v;
                   int space = offsets[i] - (pageNumber - 1) * pageHeight;
                   int breakSpan = (pageNumber * pageHeight - DRAW_PAGE_INSET * 2 - margins.top - margins.bottom) - offsets[i];
                   multipageView.setBreakSpan(breakSpan);
                   multipageView.setPageOffset(space);
                   multipageView.setStartPageNumber(pageNumber);
                   multipageView.setEndPageNumber(pageNumber);
                   int height = (int) getHeight();

                   int width = ( (BoxView) v).getWidth();
                   if (v instanceof PageableParagraphView) {
                       PageableParagraphView parView = (PageableParagraphView) v;
                       parView.layout(width, height);
                   }

                   pageNumber = multipageView.getEndPageNumber();
                   spans[i] += multipageView.getAdditionalSpace();
               }
               else {
                   offsets[i] = pageNumber * pageHeight;
                   pageNumber++;
               }
           }
           totalOffset = (int) Math.min( (long) offsets[i] + (long) spans[i], Integer.MAX_VALUE);
       }
   }
   
    @Override
   public void paint(Graphics g, Shape a) {
        DocxDocument doc=(DocxDocument)this.getDocument();
        Rectangle alloc = (a instanceof Rectangle) ? (Rectangle) a : a.getBounds();
        Shape baseClip = g.getClip().getBounds();
        int pageCount = getPageCount();
        Rectangle page = new Rectangle();      
        page.x = alloc.x;
        page.y = alloc.y;
        page.height = pageHeight;
        page.width = pageWidth;
        String sC = Integer.toString(pageCount);
        //Letrero azul que muestra en que página se está
        for (int i = 0; i < pageCount; i++) {
            page.y = alloc.y + pageHeight * i;
            paintPageFrame(g, page, (Rectangle) baseClip);
            g.setColor(Color.blue);
            String sN = Integer.toString(i + 1);
            String pageStr = "Page: " + sN;
            pageStr += " of " + sC;
            g.drawString(pageStr,page.x + page.width - 100,page.y + page.height - 3);
        }
        super.paint(g, a);
        g.setColor(Color.gray);
        // Fills background of pages
        int currentWidth = (int) alloc.getWidth();
        int currentHeight = (int) alloc.getHeight();
        int x = page.x + DRAW_PAGE_INSET;
        int y = 0;
        int w = 0;
        int h = 0;
        if (pageWidth < currentWidth) {
            w = currentWidth;
            h = currentHeight;
            g.fillRect(page.x + page.width, alloc.y, w, h);
        }
        if (pageHeight * pageCount < currentHeight) {
            w = currentWidth;
            h = currentHeight;
            g.fillRect(page.x, alloc.y + page.height * pageCount, w, h);
        }
    }
   
   /**
    * Paints frame for specified page
    * @param g Graphics
    * @param page Shape page rectangle
    * @param container Rectangle
    */
    public void paintPageFrame(Graphics g, Shape page, Rectangle container) {
        Rectangle alloc = (page instanceof Rectangle) ? (Rectangle) page : page.getBounds();
        if (container.intersection(alloc).height <= 0)
            return;
        Color oldColor = g.getColor();

        //borders
        g.setColor(Color.gray);
        g.fillRect(alloc.x, alloc.y, alloc.width, DRAW_PAGE_INSET);
        g.fillRect(alloc.x, alloc.y, DRAW_PAGE_INSET, alloc.height);
        g.fillRect(alloc.x, alloc.y + alloc.height - DRAW_PAGE_INSET, alloc.width, DRAW_PAGE_INSET);
        g.fillRect(alloc.x + alloc.width - DRAW_PAGE_INSET, alloc.y, DRAW_PAGE_INSET, alloc.height);

        //frame
        g.setColor(Color.black);
        g.drawLine(alloc.x + DRAW_PAGE_INSET, alloc.y + DRAW_PAGE_INSET, alloc.x + alloc.width - DRAW_PAGE_INSET, alloc.y + DRAW_PAGE_INSET);
        g.drawLine(alloc.x + DRAW_PAGE_INSET, alloc.y + DRAW_PAGE_INSET, alloc.x + DRAW_PAGE_INSET, alloc.y + alloc.height - DRAW_PAGE_INSET);
        g.drawLine(alloc.x + DRAW_PAGE_INSET, alloc.y + alloc.height - DRAW_PAGE_INSET, alloc.x + alloc.width - DRAW_PAGE_INSET, alloc.y + alloc.height - DRAW_PAGE_INSET);
        g.drawLine(alloc.x + alloc.width - DRAW_PAGE_INSET, alloc.y + DRAW_PAGE_INSET, alloc.x + alloc.width - DRAW_PAGE_INSET, alloc.y + alloc.height - DRAW_PAGE_INSET);

        //shadow
        g.fillRect(alloc.x + alloc.width - DRAW_PAGE_INSET, alloc.y + DRAW_PAGE_INSET + 4, 4, alloc.height - 2 * DRAW_PAGE_INSET);
        g.fillRect(alloc.x + DRAW_PAGE_INSET + 4, alloc.y + alloc.height - DRAW_PAGE_INSET, alloc.width - 2 * DRAW_PAGE_INSET, 4);

        g.setColor(oldColor);
    }

}