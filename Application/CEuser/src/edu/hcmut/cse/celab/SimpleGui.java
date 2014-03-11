package edu.hcmut.cse.celab;

import edu.hcmut.cse.celab.server.ServerWrapper;

import java.util.ArrayList;

/**
 * Created with IntelliJ IDEA.
 * User: heckarim
 * Date: 4/25/13
 * Time: 4:29 PM
 * To change this template use File | Settings | File Templates.
 */
public class SimpleGui {
    ServerWrapper serverWrapper;


    public boolean doLogin(String username, String password){
        return false;
    };
    public void doLogout(){};

    public void onSuccessLogin() {
    }

    public void onUnSuccessLogin() {
    }

    public boolean doSendRequest(RequestStructure request) {
        return false;  //To change body of created methods use File | Settings | File Templates.
    }


    public boolean doLogin(String text, char[] password) {
        return false;
    }
}
