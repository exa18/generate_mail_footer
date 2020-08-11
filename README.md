# Generate Mail Footer
Generate footer for mail. You can copy HTML code or download PNG image. You need config file to run.
You can change name of "footer" script. Image is ending with "_background" with extension jpg/png.
Config file ending with "_cfg.php".

### Config
Config file is filled with demo data. Pay attention to the field names.

  Section **table**.  Those field are for repleace content of **html** section.
  
  Section **label**.  Those are used as labels for inputs.
  
  Section **html**.  This strict inside body html code. Look for {name} to repleace.
  
  Section **form**.  Those are form field names. Polish localization set:
  ```
        'header' => 'Kreator stopki ',
        'headersml' => ' * wprowadź dane i skopiuj kod/obraz *',
        'btnhtml' => 'Kopiuj HTML',
        'btnimg' => 'Pobierz obraz',
        'badgehtml' => 'Podgląd',
        'badgeimg' => 'Pobrany obraz',
   ```

### Form
Form is generated from section **html** for field not starting with 'body' and input fields have labels from section **label**. 
Form have validation for fields: name, phone. For field name is word capitalization. 
For field phone are: 0523445566 to 52 344 55 66 and mobile 555666777 to 555 666 777.

### Password
You can protect access to script by modify .htaccess file like so:
```
<IfModule mod_auth.c>
 <Files "footer.php">
 AuthName "Members Only"
 AuthUserFile /home/user/domainpath/public_html/.htpasswd
 Require valid-user
 AuthType Basic
 </Files>
</IfModule>
```
And you need to create file .htpasswd with access [APACHE - Password formats](https://httpd.apache.org/docs/2.4/misc/password_encryptions.html).
