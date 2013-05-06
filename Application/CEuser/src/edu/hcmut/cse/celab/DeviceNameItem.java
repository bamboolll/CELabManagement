package edu.hcmut.cse.celab;

import static edu.hcmut.cse.celab.Common.CommonFunction.println;

/**
 * Created with IntelliJ IDEA.
 * User: heckarim
 * Date: 4/25/13
 * Time: 5:02 PM
 * To change this template use File | Settings | File Templates.
 * [{"device_id":"0","device_name":"Board DE2","no_total":"40","no_available":"40","description":"Altera"},{"device_id":"1","device_name":"Board PIC","no_total":"20","no_available":"20","description":"_"},{"device_id":"2","device_name":"PIC Extension Matrix Board","no_total":"20","no_available":"20","description":"_"},{"device_id":"3","device_name":"PIC LCD Board mini","no_total":"20","no_available":"20","description":"_"},{"device_id":"4","device_name":"PIC Extension LCD Board","no_total":"20","no_available":"20","description":"_"},{"device_id":"5","device_name":"PIC USB Cable","no_total":"20","no_available":"20","description":"_"},{"device_id":"6","device_name":"Board 8951","no_total":"20","no_available":"20","description":"_"},{"device_id":"7","device_name":"Com Cable 8951","no_total":"20","no_available":"20","description":"_"},{"device_id":"8","device_name":"USB Cable 8951","no_total":"20","no_available":"20","description":"_"},{"device_id":"9","device_name":"Real Time Clock 8951","no_total":"20","no_available":"20","description":"_"},{"device_id":"10","device_name":"Board H8","no_total":"20","no_available":"20","description":"_"},{"device_id":"11","device_name":"Board H8+Extension","no_total":"1","no_available":"1","description":"_"},{"device_id":"12","device_name":"T-Engine","no_total":"37","no_available":"37","description":"_"},{"device_id":"13","device_name":"LCD Touch Screen for DE2","no_total":"5","no_available":"5","description":"_"},{"device_id":"14","device_name":"Camera for DE2","no_total":"10","no_available":"10","description":"_"},{"device_id":"15","device_name":"M\u00e1y T\u00ednh","no_total":"40","no_available":"40","description":"_"},{"device_id":"16","device_name":"M\u00e0n H\u00ecnh","no_total":"40","no_available":"40","description":"_"},{"device_id":"17","device_name":"Server IBM","no_total":"1","no_available":"1","description":"_"},{"device_id":"18","device_name":"Stellaris 3748","no_total":"5","no_available":"5","description":"Texas Instruments"},{"device_id":"19","device_name":"Stellaris 6965","no_total":"5","no_available":"5","description":"Texas Instruments"}]
 */
public class DeviceNameItem {
    public int device_id;
    public String device_name;
    public int no_total;
    public int no_available;
    public String description;

    public void dump() {
        String tag="DeviceNameItem.dump()";
        println(tag, device_name + "-" + device_id + "-" + no_total + "-" + no_available + "-" + description);
    }

    public String toString(){
        return this.device_name;
    }
}
