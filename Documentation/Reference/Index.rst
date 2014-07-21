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


Reference
=========

In the following, only the XML attributes "id", "ref", "result" are
reserved words. You may use any name for other attributes, the name
has no specific interpretation in the code. Only the order and the
value are important. However, it is a good practice to use names that
make sense.

The reference attribute has a special syntax: ref = "tagName#id", where
"tagName" can be any XML tag.

"Default Method" means that if an object is used without any other
tags, this method will be applied. Example :

::

   <data id = "myData">
     5,6,7
   </data>

gives the same result as:

::

   <data id = "myData">
     <setData value = "5,6,7" />
   </data>

Table of Contents
-----------------

.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   Callback/Index
   Comments/Index
   Data/Index
   File/Index
   Foreach/Index
   Marker/Index
   Query/Index
   Template/Index
   Typo3/Index
















