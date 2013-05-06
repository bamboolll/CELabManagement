package edu.hcmut.cse.celab;

import org.omg.IOP.TAG_ALTERNATE_IIOP_ADDRESS;

import static edu.hcmut.cse.celab.Common.CommonFunction.println;

/**
 * Created with IntelliJ IDEA.
 * User: heckarim
 * Date: 4/26/13
 * Time: 12:19 PM
 * To change this template use File | Settings | File Templates.
 */
public class LogEntry {
    public int log_id;
    public int unit_id;
    public String borrower_id="";
    public String borrower_name="";
    public String return_date="";
    public String receive_date="";
    public int borrow_type;
    public int status_id;
    public String log_description="";

    public String device_name="";
    public int device_id=-1;
    public String unit_code = "";

    public void dump() {
        String tag = "LogEntry.dump()";
        println(tag,log_id +"-"+ unit_id +"-"+ borrow_type +"-"+ borrower_id +"-"+ borrower_name +"-"+ return_date +"-"+ receive_date +"-"+ status_id +"-"+ log_description);
    }

    public String toString(){
        String s = device_name + " - " + unit_code + " - " + borrower_name + " - " + borrower_id;
        if(borrow_type == 0)
            s = s + " - " + "InLab";
        else
            s = s + " - " + "OutLab";
        if(status_id == 0)
            s = s + " -" + "Borrow";
        else if(status_id == 2)
            s= s + "-" + "Return";
        s = s + " - " + receive_date;
        s = s + " - " + return_date;

        return s;
    }

    /*
    gurantee no variable is null
     */
    public void formatDAta() {
        if(log_description == null)
            log_description = " ";

    }
}
