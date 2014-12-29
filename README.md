managerResize
=============

Plugin to show thumbs instead of fullsized images in manager

To use with managermanager add to mm_rules:
mm_widget_showimagetvs('','300','100','../assets/plugins/managerResize/resizer.php');

To use with MultiTV insert the following code into the input option values:
@INCLUDE/assets/tvs/multitv/_multitv.customtv.php 

Plugin creates thumbs with phpthumb by default. To use KCFinder's thumbs change the value of "Resizer class" setting to "kcResizer" - other settings will be ignored in such case.