package edu.hcmut.cse.celab;

import javax.swing.*;
import java.awt.event.*;

public class SearchDialog extends JDialog {
    private final RequestForm mRequestForm;
    private JPanel contentPane;
    private JButton buttonOK;
    private JButton buttonCancel;
    private JTextField tfNameSearch;
    private JTextField tfIDSearch;
    private JLabel lblNameSeach;

    public SearchDialog(RequestForm requestForm) {
        setContentPane(contentPane);
        setModal(true);
        getRootPane().setDefaultButton(buttonOK);
        this.mRequestForm = requestForm;
        buttonOK.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                onOK();
            }
        });

        buttonCancel.addActionListener(new ActionListener() {
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
        SearchDialog dialog = new SearchDialog(null);
        dialog.pack();
        dialog.setVisible(true);
        System.exit(0);
    }
}
