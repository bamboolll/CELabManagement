package edu.hcmut.cse.celab;

import edu.hcmut.cse.celab.Common.CommonFunction;
import edu.hcmut.cse.celab.Common.Log;

import javax.swing.*;
import javax.swing.event.ChangeEvent;
import javax.swing.event.ChangeListener;
import java.awt.event.*;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;

public class RequestForm extends JDialog {
    private static final String TAG = "RequestForm" ;
    private JPanel contentPane1;
    private JButton btnOK;
    private JButton btnCancel;
    private JComboBox cbDevName;
    private JComboBox cbDevUnit;
    private JTextField tfTime;
    private JRadioButton insideLabRadioButton;
    private JRadioButton outsideLabRadioButton;
    private JTextField tfUserName;
    private JTextField tfUserID;
    private JPanel jplBorrow;
    private JLabel lbl_status;
    private JTextArea taNotes;
    private JTabbedPane tabbedPane1;
    private JComboBox cbStudentInfoRet;
    private JTextField tfTimeRet;
    private JRadioButton insideLabRadioButton1;
    private JRadioButton outsideLabRadioButton1;
    private JTextArea taNoteRet;
    private JList lstStatusRet;
    private JTextField tfTimeBorrowRet;
    private JButton btnRefresh;
    private JTextField tfDevicenameRet;
    private JTextField tfDeviceUnitRet;
    private JButton btnSearchRet;
    private JLabel lblStatusRet;
    private JPanel jplReturn;
    private SimpleGui gui;

    /*
     * Load search form
     */
    private void onSearchReturnClick() {
        Log.d(TAG,"onSearchClick");
        SearchDialog dialog = new SearchDialog(this);
        dialog.pack();
        dialog.setVisible(true);
    }

    /**
     * if Tab return => need to get available borrower.
     *
     */
    private void onTabChange() {
        Log.d(TAG, "on TabChange");
    }

    public RequestForm(SimpleGui simpleGui) {
        this.gui = simpleGui;
        setContentPane(contentPane1);
        setModal(true);
        getRootPane().setDefaultButton(btnOK);

        btnOK.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                onOK();
            }
        });

        btnCancel.addActionListener(new ActionListener() {
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
        contentPane1.registerKeyboardAction(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                onCancel();
            }
        }, KeyStroke.getKeyStroke(KeyEvent.VK_ESCAPE, 0), JComponent.WHEN_ANCESTOR_OF_FOCUSED_COMPONENT);
        this.doLoadContent();

        cbDevName.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                DeviceNameItem item = (DeviceNameItem) ((JComboBox)e.getSource()).getSelectedItem();
                onDevicenameChange(item);

            }
        });

        cbDevUnit.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {

                DeviceUnitItem item = (DeviceUnitItem) ((JComboBox)e.getSource()).getSelectedItem();
                onDeviceUnitChange(item);
            }
        });
        btnSearchRet.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                onSearchReturnClick();
            }
        });
        tabbedPane1.addChangeListener(new ChangeListener() {
            @Override
            public void stateChanged(ChangeEvent e) {
                onTabChange();
            }
        });

        cbStudentInfoRet.addItemListener(new ItemListener() {
            @Override
            public void itemStateChanged(ItemEvent e) {
                if(e.getStateChange() == ItemEvent.SELECTED){
                    Object item = e.getItem();
                    doOnStudentInfoItemSelected(item);
                }
            }
        });

        btnRefresh.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                onReferesh();
            }
        });
    }

    private void onReferesh() {
       this.doLoadContent();
    }

    private void doOnStudentInfoItemSelected(Object item) {


        LogEntry logEntry = (LogEntry) item;
        Log.d(TAG,"Itemclick studentinfo");
        logEntry.dump();
        this.tfDevicenameRet.setText(logEntry.device_name);
        this.tfDeviceUnitRet.setText(""+logEntry.device_id);
        this.tfTimeBorrowRet.setText(logEntry.receive_date);
        this.tfTimeRet.setText(CommonFunction.getTimeInFormat());
    }

    private void onDeviceUnitChange(DeviceUnitItem item) {
        this.request.deviceUnitItem = item;
        doUpdateTime();

    }

    private void doUpdateTime() {
        Date date = new Date();
        String s = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").format(date);
        this.tfTime.setText(s);
        this.tfTimeRet.setText(s);
        this.request.date = s;
    }

    RequestStructure request = new RequestStructure();
    private void onDevicenameChange(DeviceNameItem item) {
        this.request.deviceNameItem = item;
        //doget available deviceunit
        ArrayList<DeviceUnitItem> listUnit = this.gui.serverWrapper.getListAvailableDeviceUnit(item.device_id);
        //TODO deviceunit update
        if(listUnit == null || listUnit.isEmpty()){
            lbl_status.setText("Error when gettting device unit");
            return;
        }
        cbDevUnit.removeAllItems();
        for(DeviceUnitItem it: listUnit){
            cbDevUnit.addItem(it);
        }
        this.onDeviceUnitChange(listUnit.get(0));

    }

    private void doLoadContent() {
        ArrayList<DeviceNameItem> listDev = this.gui.serverWrapper.getListDeviceName();
        if(listDev == null || listDev.isEmpty()){
            lbl_status.setText("Error when getting device name");
            return;
        }
        //update combox
        cbDevUnit.removeAllItems();
        cbDevName.removeAllItems();
        for(DeviceNameItem item : listDev){
            cbDevName.addItem(item);
            //cbDevName.add
           // cbDevName.add(item.device_name);
        }
        cbDevName.setSelectedIndex(0);
        this.onDevicenameChange((DeviceNameItem) cbDevName.getSelectedItem());
    }

    private void onOK() {
        //check current tab
        if(this.tabbedPane1.getSelectedIndex()==0){//Tab want to borrow
        //check name and id
        if(tfUserName.getText().isEmpty() || tfUserID.getText().isEmpty()){
            lbl_status.setText("Please fill in name and id");
            return;
        }
        this.doUpdateTime();
        this.request.name = tfUserName.getText();
        this.request.id = tfUserID.getText();
        this.request.type= insideLabRadioButton.isSelected()?RequestStructure.WANT_BORROW_INSIDE:RequestStructure.WANT_BORROW_OUTSIDE;
        this.request.description = taNotes.getText();

        }else{//Tab want to return
            LogEntry log;
            if(cbStudentInfoRet.getItemCount() <0)
                return;
            log = (LogEntry) this.cbStudentInfoRet.getItemAt(this.cbStudentInfoRet.getSelectedIndex());
            this.request.log_id = log.log_id;
            this.request.date = CommonFunction.getTimeInFormat();
            this.request.type = RequestStructure.WANT_RETURN;
        }
        if(this.tabbedPane1.getSelectedIndex()==0){
            if(!this.gui.doSendRequest(this.request))
                lbl_status.setText("Unsuccessful - please try again");
            else
                lbl_status.setText("Successful request - please contact Lab Keeper");
        }else{
            if(!this.gui.doSendRequest(this.request))
                lblStatusRet.setText("Unsuccessful - please try again");
            else
                lblStatusRet.setText("Successful request - please contact Lab Keeper");
        }
    }

    private void onCancel() {
// add your code here if necessary
        dispose();
    }

    public static void main(String[] args) {
        RequestForm dialog = new RequestForm(null);
        dialog.pack();
        dialog.setVisible(true);
        System.exit(0);
    }

    public void setSearch(String name, String id) {
        Log.d(TAG,"call setSEarach " + name + ", " + id);
        ArrayList<LogEntry> listLog = this.gui.serverWrapper.searchListLogBorrower(name, id,1);
        if(listLog == null){
            this.cbStudentInfoRet.removeAllItems();
            lblStatusRet.setText("Error on searching, do again!!");
            return;
        }
        //update combox
        cbStudentInfoRet.removeAllItems();
        for(LogEntry item : listLog){
            cbStudentInfoRet.addItem(item);
        }
        lblStatusRet.setText("Search return: " + listLog.size() + " matched");
    }
}
