//#########################DISCLAIMER############################

//#THIS FREE SOFTWARE IS PROVIDED BY THE AUTHOR "AS IS" AND     #

//#ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT        #

//#LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND    #

//#FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO       #

//#EVENT SHALL THE AUTHOR OR ANY CONTRIBUTOR BE LIABLE FOR      #

//#ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR     #

//#CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,        #

//#EFFECTS OF UNAUTHORIZED OR MALICIOUS NETWORK ACCESS;         #

//#PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,    #

//#DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED   #

//#AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT  #

//#LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)       #

//#ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN     #

//#IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.                #

//###############################################################





///////////////////////////////////////////////////////////////////////*/

/*------------------------------ NOTICE -------------------------------*\

| Product Name          :      Crud360                                  |

| Organization          :      Orbit360 (R)                             |

| Type                  :      Create, Read, Update & Delete CodeGen    |

| Author                :      Usman Mughal                             |

| Created               :      24-11-2016                               |

| Updated               :      25-11-2016                               |

| Doctype               :      PHP                                      |

| Version               :      1.0b                                     |

| Copyright             :      Orbit360(R) - http://orbit360.net        |

| License               :      Attribution Assurance License            |

|                              https://opensource.org/licenses/AAL      |

|                              read LICENSE.md for more info            |

| Dependencies          :      bootstrap 4.0, jquery 1.11.2,            |

|                              tinymce 4.4.3, maskedinput 1.4.1         |

| Platform              :      LAMP/WAMP                                |

|-----------------------------------------------------------------------|

| Serves as a major class to Manipulate database tables querying        |

| them, inserting data in a convinient way. This class incorporates     |

| Jquery/Bootstrap and several other plugins to make programmers life   |

| easier by allowing them to generate code like never before with       |

| extereme customization capabilities of crud360, developers can build  |

| any kind of a back end system with little or no coding at all.        |

| This software is capable of generation code for a database table to   |

| display records, edit records, and add records. All you need is to    |

| write name of the table you're trying to create a crud for, and       |

| voila! crud360 will take care of your tabular records editing,        |

| updating and deleting records.                                        |

| Note: Use unique keys to prevent accidental duplication upon page     |

| reload espacially when using more than one tables on one page.        |

\*---------------------------------------------------------------------*/



PREREQUISITS:

1.      This program assumes you have a database with tables having at 

      least one unique primary key with auto increment If you have such a 

      database schema, that's all whats needed.



///////////////////////////////////////////////////////////////////////*/

/*-------------------- Crud360 Feature List ---------------------------\*

| * PDO based (SQL injection free)                                     |

| * Use where clause (hide certain rows if you know SQL)               |

| * Hide/Show columns      (change order of display/forms              |

| * Displays dropdowns against linked values (with 'where' clause      |

|   filter (named placeholders :name) paired with associative key->val |

|   array to be used ) see examples                                    |

| * Override linked value dropdowns with radios (checks experimental)  |

| * Display custom dropdown values (by supplying an associative        |

|   key/value pair array)                                              |

| * Compound values (with SQL CONCAT) in linked values                 |

| * Compound values (with SQL CONCAT) in reports values                |

| * Auto Column Names                                                  |

| * Auto Table Name Headings                                           |

| * Override Column Heading                                            |

| * Format column value(s) (as image, video, link, date, hexcolor )    |

| * Force input types (override defaults)                              |

| * Set Rich text fields (using tinymce                                |

| * Auto date/datetime/timestamp picker                                |

| * Override form templates using simple tpl files                     |

| * Clip column values (all, certain fields)                           |

| * Auto hide excess columns on mobile view                            |

| * Adjust to mobile view                                              |

| * Load as many tables as you want on a single page                   |

| * Style as per your needs (your own layout)                          |

| * No javascript to write                                             |

| * Enforces a primary key with auto_increment (if your table lacks    |

|   a Primary key and an auto_increment field Crud360 will not work)   |

| * Set inputs autorequired (based on database null/not null values    |

| * Set inputs required explicitly                                     |

| * Set inputs readonly                                                |

| * Auto readonly for timestamps                                       |

| * Prevention of primarykey editing                                   |

|             AND MUCH MORE!!! AND MUCH MORE TO COME!                  |

\*--------------------------------------------------------------------*/





