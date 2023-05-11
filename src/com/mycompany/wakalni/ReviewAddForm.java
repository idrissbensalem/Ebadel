/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.wakalni;

import com.codename1.ui.Button;
import com.codename1.ui.ComboBox;
import static com.codename1.ui.Component.LEFT;
import static com.codename1.ui.Component.RIGHT;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.FontImage;
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.TextArea;
import com.codename1.ui.TextField;
import com.codename1.ui.Toolbar;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.layouts.FlowLayout;
import com.codename1.ui.util.Resources;
import com.mycompany.entities.Review;
import com.mycompany.entities.User;
import com.mycompany.services.ServiceReview;
import com.mycompany.services.ServiceUser;
import java.util.Vector;

/**
 *
 * @author messaoudi
 */
public class ReviewAddForm extends SideMenuBaseForm {
    
    public ReviewAddForm(Resources res, int art) {
        
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
        
        add(new Label("Add a report Report", "TodayTitle"));
        
        Review r = new Review();
        Vector<String> vectorrate;
        vectorrate = new Vector();
        vectorrate.add("1");
        vectorrate.add("2");
        vectorrate.add("3");
        vectorrate.add("4");
        vectorrate.add("5");
        ComboBox<String> rate = new ComboBox<>(vectorrate);
        TextField article = new TextField("", "Article", 20, TextField.USERNAME);
        TextField comment = new TextField("", "Comment", 20, TextField.USERNAME);
        
        Button addButton = new Button("ADD");
        addButton.addActionListener(e -> {
            if (Dialog.show("Succes", "The comment will be sent", "Ok", "Cancel")) {
                ServiceReview.getInstance().ajouterReview(new Review(comment.getText(), art, Integer.parseInt(rate.getSelectedItem().toString())));
                new ArticleForm(res).show();
            }            
        });
        article.getAllStyles().setMargin(LEFT, 0);
        comment.getAllStyles().setMargin(LEFT, 0);
        article.setEnabled(false);
        Label artIcon = new Label("", "TextField");
        Label commentIcon = new Label("", "TextField");
        Label rateIcon = new Label("Rating /5 : ", "TextField");
        artIcon.getAllStyles().setMargin(RIGHT, 0);
        commentIcon.getAllStyles().setMargin(RIGHT, 0);
        FontImage.setMaterialIcon(artIcon, FontImage.MATERIAL_SUBJECT, 3);
        FontImage.setMaterialIcon(commentIcon, FontImage.MATERIAL_EDIT, 3);
        Container by = BoxLayout.encloseY(
                BorderLayout.center(article).
                        add(BorderLayout.WEST, artIcon),
                BorderLayout.center(rate).
                        add(BorderLayout.WEST, rateIcon),
                BorderLayout.center(comment).
                        add(BorderLayout.WEST, commentIcon),
                addButton
        );
        add(by);
        
        setupSideMenu(res);
    }
    
}
