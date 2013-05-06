package edu.hcmut.cse.celab.server;

import org.jsoup.Connection;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

import java.io.IOException;
import java.util.HashMap;
import java.util.Map;

/**
 * Created with IntelliJ IDEA.
 * User: heckarim
 * Date: 4/25/13
 * Time: 9:38 AM
 * To change this template use File | Settings | File Templates.
 */
public class ServerInterface {
    private Map<String, String> cookies;
    private String cookie_key ="PHPSESSID";
    public String hostBaseUrl="http://localhost/celab/server.php";
    public static void main(String[] args) throws IOException {
        new ServerInterface().doTest();
    }

    private void doTest() throws IOException {
        //TODO test login function
        String tag = "doTest()";
        /*//System.setProperty("http.proxyHost", "172.28.2.6");
        String baseUrl = "http://localhost/celab/login.php";
        print(tag, "Fetching "+baseUrl+"...");
        Connection.Response res = Jsoup.connect(baseUrl)
                .method(Connection.Method.POST)
                .userAgent("Mozilla/5.0")
                .timeout(5000)
                .data("username","user")
                .data("passwd","passuser")
                .execute();

        Document doc0 = res.parse();
        Map<String, String> cookies = res.cookies();

        System.out.println("cooki " + cookies);
        System.out.println(doc0.text());
        String PHPSESSID = res.cookie("PHPSESSID");

        this.doLogin("admin","vnhcmut");
        String cookiestr = doGetCookies(this.cookie_key);
        if(cookiestr == null || cookiestr.isEmpty())
            print(tag," empty string");
        else{
            //connect with the cookie
            Document doc2 = Jsoup.connect("http://localhost/celab/status.php")
                    .cookie(this.cookie_key, cookiestr)
                    .get();
            print(tag,doc2.text());
        } */
        Document doc;
        doc = doLogin("admin","vnhcmuts");
        print(tag,doc.text());
        doc = doQuery("?what=status",null);
        print(tag,doc.text());
        doc = doLogout();
        print(tag,doc.text());
    }

    public Document doLogout() {
        return this.doQuery("?what=auth&want=logout",null);
    }

    private void print(String TAG, String s) {
        System.out.println(TAG + " : " + s);

    }

    /**
     * Do login and set cookie
     * @param username
     * @param password
     *
     */
    public Document doLogin(String username, String password){
        String baseUrl = this.hostBaseUrl+"?what=auth&want=login";
        Connection.Response res = null;
        try {
            res = Jsoup.connect(baseUrl)
                    .method(Connection.Method.POST)
                    .userAgent("Mozilla/5.0")
                    .timeout(5000)
                    .data("username", username)
                    .data("passwd", password)
                    .execute();
            res.parse();
            cookies = res.cookies();
            return res.parse();
        } catch (IOException e) {
            e.printStackTrace();  //To change body of catch statement use File | Settings | File Templates.
        }
        return null;
    }

    /**
     * Query server
     * @param query
     */
    public Document doQuery(String query, Map<String, String> map){
        String baseUrl = this.hostBaseUrl+query;
        Connection.Response res = null;
        if (map == null)
            map = new HashMap<String, String>();
        try {
            res = Jsoup.connect(baseUrl)
                    .method(Connection.Method.POST)
                    .userAgent("Mozilla/5.0")
                    .timeout(5000)
                    .data(map)
                    .cookies(cookies)
                    .execute();
            return res.parse();
        } catch (IOException e) {
            e.printStackTrace();  //To change body of catch statement use File | Settings | File Templates.
        }
        return null;
    }


    public String doGetCookies(String key){
        if(this.cookies!=null){
            return this.cookies.get(key);
        }
        return null;
    }


}
