package edu.hcmut.cse.celab;

import edu.hcmut.cse.celab.server.ServerWrapper;
import org.jsoup.nodes.Document;

import static edu.hcmut.cse.celab.Common.CommonFunction.println;

/**
 * Created with IntelliJ IDEA.
 * User: heckarim
 * Date: 4/26/13
 * Time: 12:02 PM
 * To change this template use File | Settings | File Templates.
 */
public class AdminGui extends SimpleGui {

    private static final String TAG = "AdminGui";

    public static void main(String[] args){
        new AdminGui().run();
    }
    LoginDialog loginDialog;
    private void run() {
        String tag = TAG+".run()";
        //Init variable.
        serverWrapper = new ServerWrapper(this);
        //Check Login.
        boolean logined = checkLogin();
        if(!logined){
            println(tag, "Isn't login");
             loginDialog = new LoginDialog(this);
            loginDialog.pack();
            loginDialog.setVisible(true);
        }
    }


    private boolean checkLogin() {
        return false;
    }

    public boolean doLogin(String username, String password){
        String tag = TAG + ".doLogin()"   ;
        Document doc = this.serverWrapper.doLogin(username,password);
        if(doc != null){
            doc.text();
            if(doc.text().contains("OK")){
                println(tag,"Successfull login");
                return true;
            }
            else
                return false;
        }
        return false;
    }

    public void onSuccessLogin() {
        this.loginDialog.dispose();
        AdminForm dialog = new AdminForm(this);
        dialog.pack();
        dialog.setVisible(true);
    }

    public void onUnSuccessLogin() {

    }

    public boolean doSendRequest(RequestStructure re){
        return this.serverWrapper.doSendRequest(re);
    }


    LogEntry selectedEntry;
    ConsiderDialog considerDialog;
    public void setSelectedLogEntry(LogEntry sel) {

        println(TAG,"SetSelectedLogEntry() called");
        this.selectedEntry = sel;
    }

    public void loadConsiderDialog() {
        println(TAG,"loadConsiderDiaglog()");
        considerDialog = new ConsiderDialog(this);
        considerDialog.doUpdateItem();
        considerDialog.pack();
        considerDialog.setVisible(true);

    }

    public void doRejectLogEntry() {
        boolean ret = this.serverWrapper.doRejectLogEntry(this.selectedEntry);
        if(ret){
            //update status
            //add to history

        }
        //TODO notify unsuccess
    }

    public void doAcceptLogEntry() {
        boolean ret = this.serverWrapper.doApproveLogEntry(this.selectedEntry);
        if(ret){
            this.considerDialog.dispose();

        }else{
            this.considerDialog.setFailureStatus();
        }
        //
    }
}
