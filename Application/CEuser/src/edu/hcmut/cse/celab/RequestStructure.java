package edu.hcmut.cse.celab;

import java.sql.Date;

/**
 * Created with IntelliJ IDEA.
 * User: heckarim
 * Date: 4/25/13
 * Time: 5:53 PM
 * To change this template use File | Settings | File Templates.
 */
public class RequestStructure {
    public static final int WANT_RETURN = 2;
    public static final int WANT_BORROW_INSIDE = 0;
    public static final int WANT_BORROW_OUTSIDE = 1;
    public DeviceNameItem deviceNameItem;
    public DeviceUnitItem deviceUnitItem;
    public String name;
    public String id;
    public String date;
    public int type;// 0: inside lab borrow ; 1: outside lab; 2: want to return;

    public String description;
    public int log_id; // id of log for update
}
