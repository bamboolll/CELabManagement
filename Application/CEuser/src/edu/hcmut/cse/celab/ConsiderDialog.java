package edu.hcmut.cse.celab;

import edu.hcmut.cse.celab.server.ServerWrapper;
import org.omg.IOP.TAG_ALTERNATE_IIOP_ADDRESS;

import javax.swing.*;
import java.awt.event.*;

import static edu.hcmut.cse.celab.Common.CommonFunction.println;

public class ConsiderDialog extends JDialog {
    private static final String TAG = "ConsiderDialog";
    private JPanel contentPane;
    private JButton btn_accept;
    private JButton btn_cancel;
    private JTextField tf_devicename;
    private JTextField tf_deviceunit;
    private JRadioButton rb_inlab;
    private JRadioButton rb_outlab;
    private JTextField tf_borrowtime;
    private JTextField tf_returntime;
    private JRadioButton rb_borrow;
    private JRadioButton rb_return;
    private JTextArea ta_description;
    private JButton btn_modify;
    private JButton btn_reject;
    private JTextField tf_name;
    private JTextField tf_id;
    private JLabel lbl_status;
    private JPanel jplRequestInfo;
    private JPanel jplButton;
    private AdminGui adminGui;

    public ConsiderDialog() {
        setContentPane(contentPane);
        setModal(true);
        getRootPane().setDefaultButton(btn_accept);

        btn_accept.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                onOK();
            }
        });

        btn_cancel.addActionListener(new ActionListener() {
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

    public ConsiderDialog(AdminGui adminGui) {
        this.adminGui = adminGui;
        setContentPane(contentPane);
        setModal(true);
        getRootPane().setDefaultButton(btn_accept);

        btn_accept.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                onOK();
            }
        });

        btn_cancel.addActionListener(new ActionListener() {
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

        btn_modify.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {

                onModifyChoose();
            }
        });

        btn_reject.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                onReject();
            }
        });

    }

    private void onReject() {
        this.adminGui.doRejectLogEntry();
    }

    private void onModifyChoose() {
        this.editmode = true;
        this.doUpdateItem();
    }

    private void onOK() {
        if(editmode){
            this.adminGui.selectedEntry.borrower_name = tf_name.getText();
            this.adminGui.selectedEntry.borrower_id = tf_id.getText();
            this.adminGui.selectedEntry.receive_date = tf_borrowtime.getText();
            this.adminGui.selectedEntry.return_date = tf_returntime.getText();
            this.adminGui.selectedEntry.borrow_type = (rb_outlab.isSelected())?1:0;
            this.adminGui.selectedEntry.log_description = ta_description.getText();
        }
        this.adminGui.doAcceptLogEntry();
        //dispose();

    }

    private void onCancel() {
// add your code here if necessary
        dispose();
    }

    public static void main(String[] args) {
        ConsiderDialog dialog = new ConsiderDialog();
        dialog.pack();
        dialog.setVisible(true);
        System.exit(0);
    }

    Boolean editmode = false;
    public void doUpdateItem() {
        println(TAG,"doUpdateItem() called");
        tf_devicename.setText(this.adminGui.selectedEntry.device_name);
        tf_devicename.setEditable(false);
        tf_deviceunit.setText(this.adminGui.selectedEntry.unit_code);
        tf_deviceunit.setEditable(false);
        tf_name.setText(this.adminGui.selectedEntry.borrower_name);
        tf_id.setText(this.adminGui.selectedEntry.borrower_id);
        ta_description.setText(this.adminGui.selectedEntry.log_description);
        if(this.adminGui.selectedEntry.borrow_type == 0)
            rb_inlab.setSelected(true);
        else
            rb_outlab.setSelected(true);
        if(this.adminGui.selectedEntry.status_id == 0)
            rb_borrow.setSelected(true);
        else if(this.adminGui.selectedEntry.status_id == 2)
            rb_return.setSelected(true);
        tf_borrowtime.setText(this.adminGui.selectedEntry.receive_date);
        tf_returntime.setText(this.adminGui.selectedEntry.return_date);
        //cannot edit borrow or return .
        this.rb_borrow.setEnabled(false);
        this.rb_return.setEnabled(false);
        if(!editmode){
            tf_name.setEditable(false);
            tf_id.setEditable(false);
            this.rb_inlab.setEnabled(false);
            this.rb_outlab.setEnabled(false);
            //this.rb_borrow.setEnabled(false);
            //this.rb_return.setEnabled(false);

            tf_borrowtime.setEditable(false);
            tf_returntime.setEditable(false);
        }else{
            tf_name.setEditable(true);
            tf_id.setEditable(true);
            this.rb_inlab.setEnabled(true);
            this.rb_outlab.setEnabled(true);
            //this.rb_borrow.setEnabled(true);
            //this.rb_return.setEnabled(true);

            tf_borrowtime.setEditable(true);
            tf_returntime.setEditable(true);

        }

   }

    public void setFailureStatus() {
        lbl_status.setText("FAILURE - try again");
    }

    public void setStatus(ServerWrapper.LabLogObject logRet) {
        String status  = logRet.getFistNotes();
        if(logRet.isOK())
            this.lbl_status.setText("Successful!!!");
        else
            this.lbl_status.setText("UnSuccessful " + status);


    }
}
