# Installation for local use with Wamp64 or MAMP

1. Clone the repository

2. Import "public/documents/database.sql" file into your MySQL database
     
3. Create your database access

   - Windows / Wamp64 : Duplicate "config/devPc.php.dist" and rename it "devPc.php"
   - Mac / MAMP : Duplicate "config/devMac.php.dist" and rename it "devMac.php"
   Fill it with your database credentials

4. Install dependencies with composer :

   - Twig
   - Swiftmailer
   
5. Open in your browser by pointing into the folder "public/"

6. First time access for Superadmin (Highly recommended to change it)  : 
      - pseudo : admin
      - pwd : admin

There's 3 roles for users :

- admin : The Only ones who can create/edit/remove blog posts
- editor : Can create/edit/remove comments
- new : When new user has subscribed. Admin can decide to attribute admin or edit role.

# Codacy Badge
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/16b666209eff45b3b3e46c027f275e1f "Codacy")](https://app.codacy.com/gh/Reididsorg/lemonologueduvosgien/dashboard)
   
   
