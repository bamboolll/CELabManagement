package edu.hcmut.cse.celab;

import javax.swing.*;
import javax.swing.event.ListDataEvent;
import javax.swing.event.ListDataListener;
import java.awt.event.*;
import java.util.ArrayList;

public class AdminForm extends JDialog {
    private JPanel contentPane;
    private JButton btn_select;
    private JButton btn_exit;
    private JButton btn_refresh;
    private JList lst_Pending;
    private JList lst_history;
    private JLabel lbl_status;
    private AdminGui adminGui;

    public AdminForm() {
        setContentPane(contentPane);
        setModal(true);
        getRootPane().setDefaultButton(btn_select);

        btn_select.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                onOK();
            }
        });

        btn_exit.addActionListener(new ActionListener() {
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

    public AdminForm(AdminGui adminGui) {
        this.adminGui = adminGui;
        setContentPane(contentPane);
        setModal(true);
        getRootPane().setDefaultButton(btn_select);

        btn_select.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                onOK();
            }
        });

        btn_exit.addActionListener(new ActionListener() {
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

        btn_refresh.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                onRefersh();
            }
        });
        lst_Pending.setModel(listModelPedning);

    }
    DefaultListModel<LogEntry> listModelPedning = new DefaultListModel<LogEntry>();
    private void onRefersh() {
        //Get all pending request.
        ArrayList<LogEntry> listPendingEntry = this.adminGui.serverWrapper.getPendingRequest();
        //TODO update lsit
        listModelPedning.removeAllElements();
        for(LogEntry item : listPendingEntry){
            listModelPedning.addElement(item);
        }
    }


    private void onOK() {
        int selected = lst_Pending.getSelectedIndex();
        LogEntry sel;
        if(selected>=0)
            sel = listModelPedning.get(selected);
        else
            return;

        lbl_status.setText(sel.toString());
        this.adminGui.setSelectedLogEntry(sel);
        this.adminGui.loadConsiderDialog();
    }

    private void onCancel() {
// add your code here if necessary
        dispose();
    }

    public static void main(String[] args) {
        AdminForm dialog = new AdminForm();
        dialog.pack();
        dialog.setVisible(true);
        System.exit(0);
    }
}
