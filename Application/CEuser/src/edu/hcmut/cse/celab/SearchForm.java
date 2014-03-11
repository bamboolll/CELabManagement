package edu.hcmut.cse.celab;

import com.sun.webpane.webkit.dom.HTMLAnchorElementImpl;

import javax.swing.*;
import java.awt.event.*;

public class SearchForm extends JDialog {
    private JPanel contentPane;
    private JButton btnOkSearch;
    private JButton btnCancelSearch;
    private JTextField tfNameSearch;
    private JTextField tfIDSearch;
    private RequestForm mRequestForm;

    public SearchForm(RequestForm requestForm) {
        setContentPane(contentPane);
        setModal(true);
        getRootPane().setDefaultButton(btnOkSearch);
        this.mRequestForm = requestForm;
        btnOkSearch.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                onOK();
            }
        });

        btnCancelSearch.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                onCancel();
            }
        });

    // call onCancel() when cross is clicked
        setDefaultCloseOperation(DO_NOTHING_ON_CLOSE);
        addWindowListener(new WindowAdapter() {
            public void windowClosing(WindowEvent e) {
                onCancel();
            }
        });

    // call onCancel() on ESCAPE
        contentPane.registerKeyboardAction(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                onCancel();
            }
        }, KeyStroke.getKeyStroke(KeyEvent.VK_ESCAPE, 0), JComponent.WHEN_ANCESTOR_OF_FOCUSED_COMPONENT);
    }

    private void onOK() {
        if(mRequestForm != null)
            mRequestForm.setSearch(tfNameSearch.getText(), tfIDSearch.getText());
        dispose();
    }

    private void onCancel() {
    // add your code here if necessary
        dispose();
    }

    public static void main(String[] args) {
        SearchForm dialog = new SearchForm(null);
        dialog.pack();
        dialog.setVisible(true);
        System.exit(0);
    }
}
