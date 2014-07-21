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



<template>
----------


================================= ================ =================================================
Tag                               Data type        Description                 
================================= ================ =================================================
template_                         Object           Creates a template object.
loadTemplate_                     Default method   Loads the template file name.
setTemplateDir_                   Method           Defines the root directory for the template.
setCopyImageDir_                  Method           Defines the root directory for the copy of the 
                                                   image.
copyImageInFile_                  Method           Copies the resulting image in a given file.
================================= ================ =================================================



.. _template:

<template [attribute]> ... </template>
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Creates a template object.

Attribute
  - id = "myTemplate"
    Optional attribute but it is requested when using
    reference to this object. The reference will be "myTemplate".


.. _loadTemplate:

<loadTemplate attribute />
^^^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Loads the template file name.

Attribute
  - file = "typo3conf/ext/sav\_jpgraph/templates/polarex0.xml"


.. _setTemplateDir:

<setTemplateDir attribute />
^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Defines the root directory for the template.

Attribute
  - dir = "PATH\_site"
    Sets the root directory. Any defined php constant,
    in particular all TYPO3 path constants, will be interpreted.


.. _setCopyImageDir:

<setCopyImageDir attribute />
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Defines the root directory for the copy of the image.

Attribute
  - dir = "PATH\_site"
    Sets the root directory. Any defined php constant,
    in particular all TYPO3 path constants, will be interpreted.


.. _copyImageInFile:

<copyImageInFile attribute />
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Copies the resulting image in a given file.

Attribute
  - ref = "file#1"
    Sets the root directory. A string is expected, in
    general it is the reference to a file.

  - file = "fileadmin/test.png"
    Destination file.


