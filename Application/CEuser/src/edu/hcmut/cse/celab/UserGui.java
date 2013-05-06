package edu.hcmut.cse.celab;

import edu.hcmut.cse.celab.server.ServerWrapper;
import org.jsoup.nodes.Document;

import static edu.hcmut.cse.celab.Common.CommonFunction.println;

/**
 * Created with IntelliJ IDEA.
 * User: heckarim
 * Date: 4/25/13
 * Time: 1:59 PM
 * To change this template use File | Settings | File Templates.
 */
public class UserGui extends SimpleGui {
    private static final String TAG = "UserGui";
    private LoginDialog logindialog;

    public UserGui(){
    }

    public static void main(String[] args){
       new UserGui().run();
    }

    private void run() {
        String tag = TAG+".run()";
        //Init variable.
        serverWrapper = new ServerWrapper(this);
        //Check Login.
        boolean logined = checkLogin();
        if(!logined){
            println(tag, "Isn't login");
             logindialog = new LoginDialog(this);
            logindialog.pack();
            logindialog.setVisible(true);
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
        logindialog.dispose();
        RequestForm dialog = new RequestForm(this);
        dialog.pack();
        dialog.setVisible(true);

    }

    public void onUnSuccessLogin() {
    }

    public boolean doSendRequest(RequestStructure re){
        return this.serverWrapper.doSendRequest(re);
    }


}
