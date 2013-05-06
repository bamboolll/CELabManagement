package edu.hcmut.cse.celab;

import static edu.hcmut.cse.celab.Common.CommonFunction.println;

/**
 * Created with IntelliJ IDEA.
 * User: heckarim
 * Date: 4/25/13
 * Time: 5:55 PM
 * To change this template use File | Settings | File Templates.
 */
public class DeviceUnitItem {
    public int unit_id;
    public int device_id;
    public String unit_code;
    public String description;
    public String status;
    private String tag = "DeviceUnitItem";


    public void dump() {
        println(tag,unit_id+"-"+device_id+"-"+unit_code+"-"+description+"-"+status);
    }

    public String toString(){
        return this.unit_code;
    }
}
