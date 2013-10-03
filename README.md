# WP-Event-Manager-Importer

## Description 

Allow you to easily import a xlsx file into event-manager plugin.

## Dependencies

- Event-Manager

## Usage 

Select the import page under Events left admin top menu and follow the instructions.

## Format for XLSX :

As for now we only support basic import :
"Venue Name" (Libellé Segment) | "Venue Postal Code" (CP-Ville) | "Event MySQL-Formatted Start Date and Time" (Date) | "Event Description" (Description)

## Format for CSV :
Thanks to [meitar] (https://github.com/meitar)

venue_id,"Venue Name","Venue Street Address","Venue Extended Address","Venue City","Venue State","Venue Postal Code","Venue Country Code","Venue Web Address","Venue Description",event_id,venue_id,"Event Name","Event Status","Event MySQL-Formatted Start Date and Time","Event MySQL-Formatted End Date and Time","Event Web Address","Event Description"

Example file:



## Credits

This plugin have been developped by Soixante Circuits team members that are :

- https://github.com/gabrielstuff
- https://github.com/qwazerty
- https://github.com/schobbent

The following classes are used :

- [simplexlsx] (http://www.phpclasses.org/package/6279-PHP-Parse-and-retrieve-data-from-Excel-XLS-files.html)
