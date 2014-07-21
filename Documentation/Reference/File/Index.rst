.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


<file>
------


================================= ================ =================================================
Tag                               Data type        Description                 
================================= ================ =================================================
file_                             Object           Creates a file object.
setFile_                          Default Method   Defines the file name.
setFileDir_                       Method           Defines the root directory.
exportCSV_                        Method           Adds an icon to the graph which is linked to a 
                                                   CSV file containing data.
================================= ================ =================================================


.. _file:

<file [attribute]> ... </file>
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Creates a file object.

Attribute
  - id = "myFile"
    Optional attribute but it is requested when using
    reference to this object. The reference will be "myFile".

    Note: id = "1" defines the file used by default for saving the resulting
    image in the "typo3temp/sav\_jpgraph" folder. The file name is
    "img\_xxx" where "xxx" is the id of the content object.



.. _setFile:

<setFile attribute />
^^^^^^^^^^^^^^^^^^^^^

Description
  Defines the fileName.

Attribute
  - value = "fileadmin/test.png"



.. _setFileDir:

<setFileDir attribute />
^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Defines the root directory.

Attribute
  - dir = "PATH\_site"
    Sets the root directory. Any defined php constant,
    in particular all TYPO3 path constants, will be interpreted.



.. _exportCSV:

<exportCSV attributes />
^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Adds an icon to the graph which is linked to a CSV file containing data.

Attributes
  - ref_rowHeader = "data#rowHeader"
    The first argument is generally a reference to a <data> tag which contains the row header values.

  - ref_data = "data#myData"
    The second attribute is generally a reference a <data> tag .

  - If set, the third argument is interpreted as a column header attribute.
    It is also generally a reference to a <data> tag  containing the header values.
    It means that data are arrays of arrays.

  - If set, the fourth argument is interpreted as a group header argument. Group header values are displayed
    in the second column of the CSV file. They are generally defined by a reference to a <data> tag.
    It means also that data are organized as grouped arrays of arrays. In general, it is used with data coming
    from queries having a GROUP BY clause.















