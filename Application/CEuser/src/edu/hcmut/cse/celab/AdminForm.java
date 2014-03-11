package edu.hcmut.cse.celab;

import com.sun.xml.internal.ws.api.streaming.XMLStreamReaderFactory;
import edu.hcmut.cse.celab.Common.Log;
import edu.hcmut.cse.celab.server.ServerWrapper;

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
    private JList lst_log;
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

        lst_history.setModel(listModelHistory);

        lst_log.setModel(listModelLogs);
        onRefersh();
    }

    DefaultListModel<String> listModelLogs = new DefaultListModel<String>();
    DefaultListModel<LogEntry> listModelPedning = new DefaultListModel<LogEntry>();
    DefaultListModel<HistoryConsideredRequest> listModelHistory = new DefaultListModel<HistoryConsideredRequest>();
    public void onRefersh() {
        Log.d("AdminForm", "call onreferesh");
        //Get all pending request.
        String status = "contacting server";
        this.lbl_status.setText(status);
        ArrayList<LogEntry> listPendingEntry = this.adminGui.serverWrapper.getPendingRequest();
        listModelPedning.removeAllElements();
        if(listPendingEntry !=  null){
            for(LogEntry item : listPendingEntry){
                listModelPedning.addElement(item);
            }
            status = "Has " + listPendingEntry.size() + " requests";
        }
        status = " Has no new request";
        this.lbl_status.setText(status);

    }


    private void onOK() {
        int selected = lst_Pending.getSelectedIndex();
        LogEntry sel;
        if(selected>=0)
            sel = listModelPedning.get(selected);
        else
            return;
        this.updateStatus(sel.toString());
        this.adminGui.setSelectedLogEntry(sel);
        this.adminGui.loadConsiderDialog();
    }

    private void updateStatus(String str){
        lbl_status.setText(str);
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

    public void updateLogs(ServerWrapper.LabLogObject logRet) {
        ArrayList<String> notes = logRet.getNotes();
        if(notes != null){
            for (int i = 0; i<notes.size(); i++){
                this.listModelLogs.addElement(notes.get(i));
            }
        }
    }

    public class HistoryConsideredRequest{
        LogEntry logEntry;
        boolean approve;

        public HistoryConsideredRequest(LogEntry logEntry, boolean approve) {
            this.logEntry = logEntry;
            this.approve = approve;
        }

        public String toString(){
            String apprv = approve?"Accept-":"Reject-";
            return apprv+logEntry.toString();
        }
    }
    public void doUpdateHistory(LogEntry logEntry, boolean approve) {
        HistoryConsideredRequest his = new HistoryConsideredRequest(logEntry, approve);
        //listModelHistory.removeAllElements();
        listModelHistory.addElement(his);
        if(approve){
            this.updateStatus("Accept " + logEntry.toString());
        }else
            this.updateStatus("Reject " + logEntry.toString());
        onRefersh();
    }
}
