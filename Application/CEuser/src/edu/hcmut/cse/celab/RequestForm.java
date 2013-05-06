package edu.hcmut.cse.celab;

import com.sun.deploy.config.JCPConfig;

import javax.swing.*;
import java.awt.event.*;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;

public class RequestForm extends JDialog {
    private JPanel contentPane1;
    private JButton buttonOK;
    private JButton buttonCancel;
    private JComboBox cb_devname;
    private JComboBox comboBox2;
    private JTextField tf_time;
    private JRadioButton insideLabRadioButton;
    private JRadioButton outsideLabRadioButton;
    private JTextField tf_name;
    private JTextField tf_id;
    private JPanel content;
    private JLabel lbl_status;
    private JTextArea ta_notes;
    private JTabbedPane tabbedPane1;
    private JList list1;
    private JTextField textField1;
    private JTextField textField2;
    private SimpleGui gui;

    public RequestForm() {
        setContentPane(contentPane1);
        setModal(true);
        getRootPane().setDefaultButton(buttonOK);

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
        contentPane1.registerKeyboardAction(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                onCancel();
            }
        }, KeyStroke.getKeyStroke(KeyEvent.VK_ESCAPE, 0), JComponent.WHEN_ANCESTOR_OF_FOCUSED_COMPONENT);
    }

    public RequestForm(SimpleGui simpleGui) {
        this.gui = simpleGui;
        setContentPane(contentPane1);
        setModal(true);
        getRootPane().setDefaultButton(buttonOK);

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
        contentPane1.registerKeyboardAction(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                onCancel();
            }
        }, KeyStroke.getKeyStroke(KeyEvent.VK_ESCAPE, 0), JComponent.WHEN_ANCESTOR_OF_FOCUSED_COMPONENT);
        this.doLoadContent();

        cb_devname.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                DeviceNameItem item = (DeviceNameItem) ((JComboBox)e.getSource()).getSelectedItem();
                onDevicenameChange(item);

            }
        });

        comboBox2.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {

                DeviceUnitItem item = (DeviceUnitItem) ((JComboBox)e.getSource()).getSelectedItem();
                onDeviceUnitChange(item);
            }
        });
    }

    private void onDeviceUnitChange(DeviceUnitItem item) {
        this.request.deviceUnitItem = item;
        doUpdateTime();

    }

    private void doUpdateTime() {
        Date date = new Date();
        String s = new SimpleDateFormat("yyyy-mm-dd HH:mm:ss").format(date);
        this.tf_time.setText(s);
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
        comboBox2.removeAllItems();
        for(DeviceUnitItem it: listUnit){
            comboBox2.addItem(it);
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
        comboBox2.removeAllItems();
        for(DeviceNameItem item : listDev){
            cb_devname.addItem(item);
            //cb_devname.add
           // cb_devname.add(item.device_name);
        }
        this.onDevicenameChange(listDev.get(0));

    }

    private void onOK() {
        //check name and id
        if(tf_name.getText().isEmpty() || tf_id.getText().isEmpty()){
            lbl_status.setText("Please fill in name and id");
            return;
        }
        this.doUpdateTime();
        this.request.name = tf_name.getText();
        this.request.id = tf_id.getText();
        this.request.type= insideLabRadioButton.isSelected()?0:1;
        this.request.description = ta_notes.getText();
        if(!this.gui.doSendRequest(this.request))
            lbl_status.setText("Unsuccessful - please try again");
        else
            lbl_status.setText("Successful request - please contact Lab Keeper");
    }

    private void onCancel() {
// add your code here if necessary
        dispose();
    }

    public static void main(String[] args) {
        RequestForm dialog = new RequestForm();
        dialog.pack();
        dialog.setVisible(true);
        System.exit(0);
    }
}
