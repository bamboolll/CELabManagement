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
    public static final int STATUS_WANT_BORROW = 0;
    public static final int STATUS_BORROWED = 1;
    public static final int STATUS_WANT_RETURN = 2;
    public static final int STATUS_RETURNED = 3;
    public static final int STATUS_REJECT = 5;

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
        println(tag,device_name + "-" + device_id  +"-" + unit_code);
    }

    public String toString(){
        String s =   borrower_name + "(" + borrower_id + ")" +  " - " +device_name;
//        if(borrow_type == 0)
//            s = s + "-" + "Inside";
//        else
//            s = s + "-" + "Outside";
//        if(status_id == 0)
//            s = s + "-" + "Borrow";
//        else if(status_id == 2)
//            s= s + "-" + "Return";

        return s;
    }

    /*
    guarantee no variable is null
     */
    public void formatDAta() {
        if(log_description == null)
            log_description = " ";

    }
}
