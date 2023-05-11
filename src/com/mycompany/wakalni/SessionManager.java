/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.wakalni;

import com.codename1.io.Preferences;

/**
 *
 * @author houssem
 */
public class SessionManager {
     public static Preferences pref ; // 3ibara memoire sghira nsajlo fiha data 

    // hethom données ta3 user lyt7b tsajlhom fi session  ba3d login 
    private static int id ; 
    private static String code ; 
  

    public static Preferences getPref() {
        return pref;
    }

    public static void setPref(Preferences pref) {
        SessionManager.pref = pref;
    }

    public static int getId() {
        return pref.get("id",id);// kif nheb njib id user connecté apres njibha men pref 
    }

    public static void setId(int id) {
        pref.set("id",id);//nsajl id user connecté  w na3tiha identifiant "id";
    }
    
     public static String getCode() {
        return pref.get("code",code);// kif nheb njib id user connecté apres njibha men pref 
    }

    public static void setCode(String code) {
        pref.set("code",code);//nsajl id user connecté  w na3tiha identifiant "id";
    }
}
