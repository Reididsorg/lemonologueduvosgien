# Installation for local use with Wamp64 or MAMP

1. Clone the repository

2. Import "public/documents/database.sql" file into your MySQL database
     
3. Create your database access

   - Windows / Wamp64 : Duplicate "config/devPc.php.dist" and rename it "devPc.php"
   - Mac / MAMP : Duplicate "config/devMac.php.dist" and rename it "devMac.php"
   Fill it with your database credentials

4. Fill your mail credentials :

   - Duplicate "config/devMail.php.dist" and rename it "devMail.php"

5. Fill your recaptcha credentials :

   - Duplicate "config/devRecaptcha.php.dist" and rename it "devRacaptcha.php" (Fill with server credential)
   - Open templates/front/getContact.html.twig and fill with front credential at the bottom (2 lines)
   - Open templates/front/register.html.twig and fill with front credential at the bottom (2 lines)

6. Install dependencies with composer :

   - Twig
   - Swiftmailer
   
7. Open in your browser by pointing into the folder "public/"

8. First time access for Superadmin (Highly recommended to change it)  : 
      - pseudo : admin
      - pwd : admin

There's 3 roles for users :

- admin : The Only ones who can create/edit/remove blog posts
- editor : Can create/edit/remove comments
- new : When new user has subscribed. Admin can decide to attribute admin or edit role.

:)

# Codacy Badge
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/16b666209eff45b3b3e46c027f275e1f)](https://www.codacy.com/gh/Reididsorg/lemonologueduvosgien/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Reididsorg/lemonologueduvosgien&amp;utm_campaign=Badge_Grade)
