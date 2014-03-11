package edu.hcmut.cse.celab.Common;

import java.text.SimpleDateFormat;
import java.util.Date;

/**
 * Created with IntelliJ IDEA.
 * User: heckarim
 * Date: 4/25/13
 * Time: 3:58 PM
 * To change this template use File | Settings | File Templates.
 */
public class CommonFunction {

    public static void println(String tag, String s){
        System.out.println(tag + ": " + s);

    }

    public static String getTimeInFormat(){
        Date date = new Date();
        String s = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").format(date);
        return s;
    }
}
