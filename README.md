Human & Material Resources Management System
=========================



### ![](https://younes-khoubaz.netlify.app/assets/icons/info-shrinked.png) Useful Information

*   The web application is mainly in French. Please consider using a translator extension such as Google Translator or your browser's built-in translator to translate the entire page.
*   default login:  
    username: **admin**  
    password: **admin**
    

### Introduction

As an intern, I was tasked with developing a web application to manage the employees and equipment in the various rooms of the Court of Appeal. The Court of Appeal has great difficulty managing the employees working there and efficiently distributing equipement (printers, computers, monitors...) to workspaces. As well as handling an archive.

  
This application offers several services to the administration: It simplifies the task of managing all employees and tracking their relocations between workspaces, as well as managing the inventory of equipment provided by the government. It also features an archive section which keeps all the records of old employees and inventory.


### Specifications (+ Overall use cases)

*   Have a single user who has control and full access to the application (administrator).
*   The administrator can authenticate in full security, with the ability to change the password and username.
*   Add/Delete employees with their necessary infos.
*   The workspace of each employee is specified when the employee is added, which means that you cannot have an employee without a workspace.
*   All information about employees can be changed.
*   The application saves the transfer date each time an employee is transferred to another room and calculates the time they have been there.
*   Deleting an employee only marks that this employee has left. The identifying information and transfer history about the employee remains accessible in the archive.
*   Equipment can be added with details, type, model and quantity (the detail field, where information such as configuration, price or other notes are stored, is not mandatory).
*   Equipment is automatically saved in the storage room when it is added, after which it can be added to the rooms.
*   Removing equipment only marks that the item has been removed and is not displayed in the equipment table. But all information and the quantity that circulates between the workspaces and the inventory remain accessible in the archive.
*   The application must have the archive area for employees and equipment with the ability to restore them.
*   The name and number are mandatory when creating a room, you can then add equipment (optional).
*   Multiple pieces of equipment can be added to a room in any number.
*   The application ensures that the quantity that can be added is sufficient, displaying the selection of equipment depending on the equipment already in the warehouse.
*   The application manages the storage quantity dynamically when a quantity of equipment is added/removed from a workspace.
*   You can change the name and number of the room and the number of equipment already in the room and add new equipment to the room when it is changed.
*   The application must ensure that a workspace is empty of employees and devices before deleting it.
*   Navigation of the application should be simple and intuitive.
*   The application should include a search function in each section to help find records based on any information provided.
*   Tables must be indexed, with the functionality to sort them by column.
*   The application must handle special cases where errors may occur.
*   If an error occurs, the application must display a message containing the type of error.


### A Walkthrough:

#### Login page

![Login page](https://younes-khoubaz.netlify.app/assets/court-management-system/1.jpeg)

#### Employees Page

![](https://younes-khoubaz.netlify.app/assets/court-management-system/6.1.jpeg)

Adding an employee: ![](https://younes-khoubaz.netlify.app/assets/court-management-system/5.jpeg)

![](https://younes-khoubaz.netlify.app/assets/court-management-system/6.jpeg)

Checking the details of the recently added employee by clicking on the eye icon. The system also tracks the employee's transfers between court rooms. ![](https://younes-khoubaz.netlify.app/assets/court-management-system/7.gif)

#### Equipment page

Here we can see all the equipment that is in the inventory with the available stock and other details. ![](https://younes-khoubaz.netlify.app/assets/court-management-system/10.jpeg)

Adding an equipment: ![](https://younes-khoubaz.netlify.app/assets/court-management-system/11.jpeg)

![](https://younes-khoubaz.netlify.app/assets/court-management-system/12.jpeg)

The recently added equipment doesn't appear in any room as we haven't added it in one yet. ![](https://younes-khoubaz.netlify.app/assets/court-management-system/13.jpeg)

#### Workspaces page

![](https://younes-khoubaz.netlify.app/assets/court-management-system/15.jpeg)

Let's check the room of expertise _("Section d'expertise")_. We can see that the newly added employee is working there and there is no equipment.
![](https://younes-khoubaz.netlify.app/assets/court-management-system/16.jpeg)

So let's modify the room by adding the recently added equipment and changing the name of the room to something like "Physics Lab".
![](https://younes-khoubaz.netlify.app/assets/court-management-system/17.jpeg)

![](https://younes-khoubaz.netlify.app/assets/court-management-system/18.jpeg)

We can now see the added equipment with quantity on the details page of the workspace. ![](https://younes-khoubaz.netlify.app/assets/court-management-system/19.jpeg)

If we check the details page of the equipment, we can see the remaining stock in the inventory and the workspaces that hold that particular equipment. ![](https://younes-khoubaz.netlify.app/assets/court-management-system/20.jpeg)

#### Archive page

![](https://younes-khoubaz.netlify.app/assets/court-management-system/22.jpeg)

Delteting the recently added equipment and employee _(When deleting equipment, all stocks in the inverntory and in workspaces are deleted together)_. ![](https://younes-khoubaz.netlify.app/assets/court-management-system/9.jpeg) ![](https://younes-khoubaz.netlify.app/assets/court-management-system/14.jpeg)

![](https://younes-khoubaz.netlify.app/assets/court-management-system/24.jpeg)

![](https://younes-khoubaz.netlify.app/assets/court-management-system/26.jpeg) ![](https://younes-khoubaz.netlify.app/assets/court-management-system/27.jpeg)

A worskspace must be selected when the employee is restored.

![](https://younes-khoubaz.netlify.app/assets/court-management-system/28.jpeg) ![](https://younes-khoubaz.netlify.app/assets/court-management-system/29.jpeg)
