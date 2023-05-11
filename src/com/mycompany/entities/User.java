/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.entities;

/**
 *
 * @author houssem
 */
public class User {
    
    private int ID;
    private String email;
    private String gender;
    private String password;
    private String firstname;
    private String lastname;
    private int age;
    private int phonenumber;
    private String image;
    private String adresse;
    private String role;
    
    public User() {
    }

    public User(int ID, String email, String roles, String password, String firstname, String lastname, int age, int phonenumber, String image) {
        this.ID = ID;
        this.email = email;
        this.gender = roles;
        this.password = password;
        this.firstname = firstname;
        this.lastname = lastname;
        this.age = age;
        this.phonenumber = phonenumber;
        this.image = image;
    }
    
    public User(String email, String genders, String password, String firstname, String lastname, int age, int phonenumber, String image, String adresse) {
        this.email = email;
        this.gender = genders;
        this.password = password;
        this.firstname = firstname;
        this.lastname = lastname;
        this.age = age;
        this.phonenumber = phonenumber;
        this.image = image;
        this.adresse = adresse;
    }

    public User(int ID, String email, String gender, String password, String firstname, String lastname, int age, int phonenumber, String adresse, String role) {
        this.ID = ID;
        this.email = email;
        this.gender = gender;
        this.password = password;
        this.firstname = firstname;
        this.lastname = lastname;
        this.age = age;
        this.phonenumber = phonenumber;
        this.image = image;
        this.adresse = adresse;
        this.role = role;
    }
    
    

    public int getID() {
        return ID;
    }

    public void setID(int ID) {
        this.ID = ID;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getGender() {
        return gender;
    }

    public void setGender(String gender) {
        this.gender = gender;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getFirstname() {
        return firstname;
    }

    public void setFirstname(String firstname) {
        this.firstname = firstname;
    }

    public String getLastname() {
        return lastname;
    }

    public void setLastname(String lastname) {
        this.lastname = lastname;
    }

    public int getAge() {
        return age;
    }

    public void setAge(int age) {
        this.age = age;
    }

    public int getPhonenumber() {
        return phonenumber;
    }

    public void setPhonenumber(int phonenumber) {
        this.phonenumber = phonenumber;
    }

    public String getImage() {
        return image;
    }

    public void setImage(String image) {
        this.image = image;
    }
    
    public String getAdresse() {
        return adresse;
    }

    public void setAdresse(String adresse) {
        this.adresse = adresse;
    }    

    public String getRole() {
        return role;
    }

    public void setRole(String role) {
        this.role = role;
    }

    @Override
    public String toString() {
        return "User{" + "ID=" + ID + ", email=" + email + ", gender=" + gender + ", password=" + password + ", firstname=" + firstname + ", lastname=" + lastname + ", age=" + age + ", phonenumber=" + phonenumber + ", image=" + image + ", adresse=" + adresse + '}';
    }

}
