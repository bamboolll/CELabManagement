package edu.hcmut.cse.celab.server;

import com.google.gson.*;
import edu.hcmut.cse.celab.*;
import edu.hcmut.cse.celab.Common.Log;
import org.jsoup.nodes.Document;


import java.util.*;

import static edu.hcmut.cse.celab.Common.CommonFunction.println;

/**
 * Created with IntelliJ IDEA.
 * User: heckarim
 * Date: 4/25/13
 * Time: 9:37 AM
 * To change this template use File | Settings | File Templates.
 * provide fucntions for communicate with server
 */
public class ServerWrapper {
    private static final String TAG = "ServerWrapper";
    SimpleGui gui;
    ServerInterface serverInterface;
    public ServerWrapper(SimpleGui userGui) {
        this.gui = userGui;
        serverInterface = new ServerInterface();
    }


    public Document doLogin(String name, String pass){
        return this.serverInterface.doLogin(name,pass);
    }

    public Document doLogout(){
        return this.serverInterface.doLogout();
    }

    /**
     *
     * @return
     * [{"device_id":"0","device_name":"Board DE2","no_total":"40","no_available":"40","description":"Altera"},{"device_id":"1","device_name":"Board PIC","no_total":"20","no_available":"20","description":"_"},]

     */
    public ArrayList<DeviceNameItem> getListDeviceName() {
        Document doc = this.serverInterface.doQuery("?what=req&want=read&aim=device_name&scope=all",null);
        String tag = TAG + ".getListDeviceName()";
        println(tag,doc.text());
        if(doc ==null || doc.text().contains("FAIL"))
            println(tag,"unsuccessful request");
        else{
            try{
            JsonElement json = new JsonParser().parse(doc.text());
            JsonArray array = json.getAsJsonArray();
            Iterator iterator = array.iterator();
            ArrayList<DeviceNameItem> list = new ArrayList<DeviceNameItem>();
            while(iterator.hasNext()){
                JsonElement json2 = (JsonElement)iterator.next();
                Gson gson = new Gson();
                DeviceNameItem  item = gson.fromJson(json2,DeviceNameItem.class);
                item.dump();
                list.add(item);
            }
            return list;
            }catch(JsonParseException e) {
                e.printStackTrace();
                println(tag,"not json format");
            }
        }
        return null;
    }

    public ArrayList<DeviceUnitItem> getListAvailableDeviceUnit(int device_id) {
        Document doc = this.serverInterface.doQuery("?what=req&want=read&aim=device_unit&scope=available&dev_id="+device_id,null);
        String tag = TAG + ".getListAvailableDevice()";

        println(tag,doc.text());
        if(doc == null || doc.text().contains("FAIL"))
            println(tag,"unsuccessful request");
        else{
            try{
                JsonElement json = new JsonParser().parse(doc.text());
                JsonArray array = json.getAsJsonArray();
                Iterator iterator = array.iterator();
                ArrayList<DeviceUnitItem> list = new ArrayList<DeviceUnitItem>();
                while(iterator.hasNext()){
                    JsonElement json2 = (JsonElement) iterator.next();
                    Gson gson = new Gson();
                    DeviceUnitItem item = gson.fromJson(json2,DeviceUnitItem.class);
                    item.dump();
                    list.add(item);

                }
                return list;

            }catch(JsonParseException e){
                e.printStackTrace();
                println(tag,"not json format");
            }
        }


        return null;
    }

    public boolean doSendRequest(RequestStructure re) {
        Map<String,String> data = new HashMap<String,String>();
        if(re.type == RequestStructure.WANT_BORROW_INSIDE || re.type == RequestStructure.WANT_BORROW_OUTSIDE){
                data.put("borrower_name",re.name);
                data.put("borrower_id",re.id);
                data.put("unit_id",re.deviceUnitItem.unit_id+"");
                data.put("receive_date",re.date);
                data.put("borrow_type",re.type+"");
                data.put("log_description",re.description);
                Document doc = this.serverInterface.doQuery("?what=req&want=write&aim=lab_log&scope=request_borrow",data);
                println(TAG,doc.text());
                if(doc == null || doc.text().contains("FAIL"))
                    return false;
                else
                    return true;
        }else if(re.type == RequestStructure.WANT_RETURN){
            data.put("log_id",Integer.toString(re.log_id));
            data.put("return_date",re.date);
            Document doc = this.serverInterface.doQuery("?what=req&want=write&aim=lab_log&scope=request_return",data);
            println(TAG,doc.text());
            if(doc == null || doc.text().contains("FAIL"))
                return false;
            else
                return true;
        }
        return true;
    }

    public class LabLogObject{
        String code;
        int count;
        ArrayList<LogEntry> logs;
        ArrayList<String> notes;

        public boolean isOK() {
            return (this.code != null && this.code.compareToIgnoreCase("OK")==0);
        }

        public ArrayList<String> getNotes() {
            return notes;
        }

        public String getFistNotes() {
            if(notes != null && notes.size() >0)
                return notes.get(0);
            return "";
        }
    }
    public ArrayList<LogEntry> getPendingRequest() {
        Document doc = this.serverInterface.doQuery("?what=req&want=read&aim=lab_log&scope=pending",null);
        String tag = TAG + ".getPendingRequest()";

        println(tag,doc.text());
        if(doc == null)
            println(tag,"unsuccessful request");
        else{
            try{
                JsonElement json = new JsonParser().parse(doc.text());
                Gson gson = new Gson();
                LabLogObject logObject = gson.fromJson(json,LabLogObject.class);

//
//                Iterator iterator = array.iterator();
//                ArrayList<LogEntry> list = new ArrayList<LogEntry>();
//                while(iterator.hasNext()){
//                    JsonElement json2 = (JsonElement) iterator.next();
//
//                    LogEntry item = gson.fromJson(json2,LogEntry.class);
//                    item.device_id = this.getDeviceIDfromUnitID(item.unit_id);
//                    item.device_name = this.getDeviceNamebyID(item.device_id);
//                    item.unit_code = this.getUnitCodefromUnitID(item.unit_id);
//                    item.dump();
//                    list.add(item);
//                }
                Log.d(TAG, "code: " + logObject.code + " count " + logObject.count + " - " + logObject.logs.size());

                return logObject.logs;

            }catch(JsonParseException e){
                e.printStackTrace();
                println(tag,"not json format");
            }
        }


        return null;
    }

    private String getUnitCodefromUnitID(int unit_id) {
        DeviceUnitItem item = this.lookupDeviceUnit(unit_id);
        if(item == null)
            return null;
        else
            return item.unit_code;
    }

    private String getDeviceNamebyID(int device_id) {
        DeviceNameItem item = this.lookupDeviceName(device_id);
        if(item != null)
            return item.device_name;
        else
            return "error";


    }


    public DeviceUnitItem lookupDeviceUnit(int id){
        Document doc = this.serverInterface.doQuery("?what=req&want=read&aim=device_unit&scope=lookup&unit_id="+id,null);
        String tag = TAG + ".lookupDeviceUnit() " + id;
        println(tag,doc.text());
        if(doc ==null || doc.text().contains("FAIL"))
            println(tag,"unsuccessful request");
        else{
            try{
                JsonElement json = new JsonParser().parse(doc.text());
                JsonArray array = json.getAsJsonArray();
                Iterator iterator = array.iterator();
                ArrayList<DeviceUnitItem> list = new ArrayList<DeviceUnitItem>();
                while(iterator.hasNext()){
                    JsonElement json2 = (JsonElement)iterator.next();
                    Gson gson = new Gson();
                    DeviceUnitItem  item = gson.fromJson(json2,DeviceUnitItem.class);
                    item.dump();
                    list.add(item);
                }
                if(list.isEmpty())
                    return null;
                return list.get(0);
            }catch(JsonParseException e) {
                e.printStackTrace();
                println(tag,"not json format");
            }
        }
        return null;
    }


    public DeviceNameItem lookupDeviceName(int id){
        Document doc = this.serverInterface.doQuery("?what=req&want=read&aim=device_name&scope=lookup&device_id="+id,null);
        String tag = TAG + ".lookupDeviceName()";
        println(tag,doc.text());
        if(doc ==null || doc.text().contains("FAIL"))
            println(tag,"unsuccessful request");
        else{
            try{
                JsonElement json = new JsonParser().parse(doc.text());
                JsonArray array = json.getAsJsonArray();
                Iterator iterator = array.iterator();
                ArrayList<DeviceNameItem> list = new ArrayList<DeviceNameItem>();
                while(iterator.hasNext()){
                    JsonElement json2 = (JsonElement)iterator.next();
                    Gson gson = new Gson();
                    DeviceNameItem  item = gson.fromJson(json2,DeviceNameItem.class);
                    item.dump();
                    list.add(item);
                }
                if(list.isEmpty())
                    return null;
                return list.get(0);
            }catch(JsonParseException e) {
                e.printStackTrace();
                println(tag,"not json format");
            }
        }
        return null;
    }

    private int getDeviceIDfromUnitID(int unit_id) {
        DeviceUnitItem item = this.lookupDeviceUnit(unit_id);
        if(item == null)
            return -1;
        else
            return item.device_id;
    }



    public LabLogObject doRejectLogEntry(LogEntry entry) {
        Map<String,String> data = new HashMap<String,String>();
        LabLogObject logObj = null;
        Document doc= null;
        String tag = TAG + ".doRejectLogEntry()";
        Gson gson = new Gson();
        if(entry.status_id == LogEntry.STATUS_WANT_BORROW){
            data.put("log_id",entry.log_id+"");
            data.put("log_description",entry.log_description);
            dumpData(data);

            doc = this.serverInterface.doQuery("?what=req&want=write&aim=lab_log&scope=reject_borrow",data);
        }else if(entry.status_id == LogEntry.STATUS_WANT_RETURN){
            data.put("log_id",entry.log_id+"");
            data.put("log_description",entry.log_description);
            dumpData(data);

            doc = this.serverInterface.doQuery("?what=req&want=write&aim=lab_log&scope=reject_return",data);

        }

        if(doc != null)
            println(tag,doc.text());
        if(doc == null){
            println(tag,"unsuccessful request");
            return null;
        }else{
            JsonElement je = new JsonParser().parse(doc.text());
            logObj = gson.fromJson(je,LabLogObject.class);
            return logObj;
        }
    }

    public void dumpData(Map<String,String> data){
        System.out.println("data: " + data.toString());
    }

    public LabLogObject doApproveLogEntry(LogEntry entry) {
        String tag = TAG + ".doApproveLogEntry()";
        Map<String,String> data = new HashMap<String,String>();
        entry.formatDAta();
        LabLogObject logObj = null;
        Document doc= null;
        Gson gson = new Gson();
        if(entry.status_id == LogEntry.STATUS_WANT_BORROW){
            data.put("log_id",entry.log_id+"");
            data.put("borrower_name",entry.borrower_name);
            data.put("borrower_id",entry.borrower_id+"");
            data.put("borrow_type",entry.borrow_type+"");
            data.put("unit_id",entry.unit_id+"");
            data.put("receive_date",entry.receive_date);
            data.put("status_id",entry.status_id+"");
            data.put("log_description",entry.log_description);
            println(TAG,"doApproveLogEntry() borrow called");
            entry.dump();
            doc = this.serverInterface.doQuery("?what=req&want=write&aim=lab_log&scope=approve_borrow",data);

        }else if(entry.status_id == LogEntry.STATUS_WANT_RETURN){
            data.put("log_id",entry.log_id+"");
            data.put("borrower_name",entry.borrower_name);
            data.put("borrower_id",entry.borrower_id+"");
            data.put("borrow_type",entry.borrow_type+"");
            data.put("unit_id",entry.unit_id+"");
            data.put("receive_date",entry.receive_date);
            data.put("return_date",entry.return_date);
            data.put("status_id",entry.status_id+"");
            data.put("log_description",entry.log_description);
            println(TAG,"doApproveLogEntry() return called");
            entry.dump();
            doc = this.serverInterface.doQuery("?what=req&want=write&aim=lab_log&scope=approve_return",data);

        }
        if(doc != null)
            println(tag,doc.text());
        if(doc == null){
            println(tag,"unsuccessful request");
            return null;
        }else{
            JsonElement je = new JsonParser().parse(doc.text());
            logObj = gson.fromJson(je,LabLogObject.class);
            return logObj;
        }
    }

    public ArrayList<LogEntry> searchListLogBorrower(String name, String id, int status) {
        Document doc = this.serverInterface.doQuery("?what=req&want=read&aim=lab_log&scope=search&name="+name + "&id=" + id + "&status="+status,null);
        String tag = TAG + ".searchListLogBorrower()";
        println(tag,doc.text());
        if(doc ==null || doc.text().contains("FAIL"))
            println(tag,"unsuccessful request");
        else{
            try{
                JsonElement json = new JsonParser().parse(doc.text());
                Gson gson = new Gson();
                LabLogObject logObject = gson.fromJson(json,LabLogObject.class);
                if(logObject.logs != null)
                    return logObject.logs;
                //println(tag,"notes array " + logObject.notes.size() + "-" + logObject.notes.toString());
            }catch(JsonParseException e) {
                e.printStackTrace();
                println(tag,"not json format");
            }
        }
        return null;
    }
}
