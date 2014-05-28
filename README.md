Find Shortest Route - Completed in Zendframework 1 
===============================================================

Assuming that we spec a server-side PHP solution that accepts AJAX calls (JSON or RESTful) and that the problem space is a set of train stations with rail lines running between them:

For the DHTML/CSS/JS create a web page that lists all the train stations in a listbox.

When a station is selected it is displayed to the right as the first station.

When a second station is selected it is also displayed to the right and an AJAX request is sent to the server-side PHP that calculates the shortest route between the two stations and the answer is displayed to the right.

A [Start over] button should clear the area to the right and allow the user to select a new pair of stations.

All elements should be styled using CSS, layout done WITHOUT TABLE tags and two alternative themes provided with the ability to switch between themes with a UI element on the page.

Train station conditions: not all stations have direct lines to all other stations (ie the shortest route could be via one or more other stations). 
(In an ideal scenario, the train information would be stored in a database, but for the purposes of this test, this information can be stored in arrays.)
