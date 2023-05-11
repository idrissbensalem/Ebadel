/*
 * Copyright (c) 2016, Codename One
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated 
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation 
 * the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, 
 * and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions 
 * of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, 
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A 
 * PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT 
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF 
 * CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE 
 * OR THE USE OR OTHER DEALINGS IN THE SOFTWARE. 
 */
package com.mycompany.wakalni;

import com.codename1.components.FloatingActionButton;
import com.codename1.components.MultiButton;
import com.codename1.io.Storage;
import com.codename1.ui.Button;
import com.codename1.ui.ComboBox;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.FontImage;
import com.codename1.ui.Graphics;
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.TextField;
import com.codename1.ui.Toolbar;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.layouts.FlowLayout;
import com.codename1.ui.layouts.GridLayout;
import com.codename1.ui.plaf.Style;
import com.codename1.ui.util.Resources;
import com.mycompany.entities.User;
import com.mycompany.services.ServiceUser;
import java.util.Vector;

/**
 *
 * @author houssem
 */
public class ProfileForm extends SideMenuBaseForm {

    public ProfileForm(Resources res) {
        
        super(BoxLayout.y());
        setUIID("Toolbar");
        User u = new User();
        u = ServiceUser.getInstance().getCurrent(SessionManager.getId());
        Toolbar tb = getToolbar();
        tb.setTitleCentered(false);
        Image profilePic = res.getImage("01.jpg");
        Image mask = res.getImage("round-mask.png");
        profilePic = profilePic.fill(mask.getWidth(), mask.getHeight());
        Label profilePicLabel = new Label(profilePic, "ProfilePicTitle");
        profilePicLabel.setMask(mask.createMask());

        Button menuButton = new Button("");
        menuButton.setUIID("Title");
        FontImage.setMaterialIcon(menuButton, FontImage.MATERIAL_MENU);
        menuButton.addActionListener(e -> getToolbar().openSideMenu());

        Container titleCmp = BoxLayout.encloseY(
                FlowLayout.encloseIn(menuButton),
                BorderLayout.centerAbsolute(
                        BoxLayout.encloseY(
                                new Label(u.getFirstname(), "Title"),
                                new Label(u.getEmail(), "SubTitle")
                        )
                ).add(BorderLayout.WEST, profilePicLabel)
        );

        tb.setTitleComponent(titleCmp);

        add(new Label("Profile", "TodayTitle"));

       
        TextField aa = new TextField();
        TextField email = new TextField(u.getEmail(), "Email", 20, TextField.EMAILADDR);
        TextField firstname = new TextField(u.getFirstname(), "First Name", 20, TextField.USERNAME);
        TextField lastname = new TextField(u.getLastname(), "Last Name", 20, TextField.USERNAME);
        TextField age = new TextField(String.valueOf(u.getAge()), "Age", 20, TextField.NUMERIC);
        TextField phonenumber = new TextField(String.valueOf(u.getPhonenumber()), "Phone Number", 20, TextField.PHONENUMBER);
        TextField adresse = new TextField(u.getAdresse(), "Addresse", 20, TextField.USERNAME);
        TextField gender = new TextField(u.getGender(), "Gender", 20, TextField.USERNAME);
        Button modButton = new Button("Save");
        modButton.setUIID("LoginButton");
        modButton.addActionListener(e -> {
            ServiceUser.getInstance().edit(email.getText().toString(), firstname.getText().toString(), lastname.getText().toString(), Integer.parseInt(age.getText())
                    , phonenumber.getText().toString(),gender.getText().toString(),adresse.getText().toString(), res);
            Dialog.show("Success", "account is saved", "OK", null);
            new ProfileForm(res).show();
        });
        Button delButton = new Button("Deactivate account");
        delButton.addActionListener(e -> {
            if (Dialog.show("Success", "The account will be permanently deleted, Are you sure ?", "Ok", "Cancel")){
                ServiceUser.getInstance().delete(SessionManager.getId());
                new LoginForm(res).show();
                SessionManager.pref.clearAll();
                Storage.getInstance().clearStorage();
                Storage.getInstance().clearCache();
            }
                else{
                new ProfileForm(res).show();
            }
        });
        Button passwordButton = new Button("Change password");
        passwordButton.addActionListener(e -> {
            new ResetPasswordForm(res).show();
        });
        email.getAllStyles().setMargin(LEFT, 0);
        firstname.getAllStyles().setMargin(LEFT, 0);
        lastname.getAllStyles().setMargin(LEFT, 0);
        age.getAllStyles().setMargin(LEFT, 0);
        phonenumber.getAllStyles().setMargin(LEFT, 0);
        adresse.getAllStyles().setMargin(LEFT, 0);
        gender.getAllStyles().setMargin(LEFT, 0);
        Label emailIcon = new Label("", "TextField");
        Label firstnameIcon = new Label("", "TextField");
        Label lastnameIcon = new Label("", "TextField");
        Label ageIcon = new Label("", "TextField");
        Label phonenumberIcon = new Label("", "TextField");
        Label genderIcon = new Label("", "TextField");
        Label addresseIcon = new Label("", "TextField");
        emailIcon.getAllStyles().setMargin(RIGHT, 0);
        firstname.getAllStyles().setMargin(RIGHT, 0);
        lastname.getAllStyles().setMargin(RIGHT, 0);
        ageIcon.getAllStyles().setMargin(RIGHT, 0);
        addresseIcon.getAllStyles().setMargin(RIGHT, 0);
        genderIcon.getAllStyles().setMargin(RIGHT, 0);
        phonenumberIcon.getAllStyles().setMargin(RIGHT, 0);
        FontImage.setMaterialIcon(emailIcon, FontImage.MATERIAL_EMAIL, 3);
        FontImage.setMaterialIcon(firstnameIcon, FontImage.MATERIAL_PERSON, 3);
        FontImage.setMaterialIcon(lastnameIcon, FontImage.MATERIAL_PERSON, 3);
        FontImage.setMaterialIcon(phonenumberIcon, FontImage.MATERIAL_PHONE, 3);
        FontImage.setMaterialIcon(ageIcon, FontImage.MATERIAL_PERSON, 3);
        FontImage.setMaterialIcon(addresseIcon, FontImage.MATERIAL_HOME, 3);
        FontImage.setMaterialIcon(genderIcon, FontImage.MATERIAL_PERSON, 3);
        Container by = BoxLayout.encloseY(
                BorderLayout.center(email).
                add(BorderLayout.WEST, emailIcon),
                BorderLayout.center(firstname).
                add(BorderLayout.WEST, firstnameIcon),
                BorderLayout.center(lastname).
                add(BorderLayout.WEST, lastnameIcon),
                BorderLayout.center(age).
                add(BorderLayout.WEST, ageIcon),
                BorderLayout.center(phonenumber).
                add(BorderLayout.WEST, phonenumberIcon),
                BorderLayout.center(adresse).
                add(BorderLayout.WEST, addresseIcon),
                BorderLayout.center(gender).
                add(BorderLayout.WEST, genderIcon),
                modButton,
                delButton,
                passwordButton
        );
        add(by);
        setupSideMenu(res);
    }

}
