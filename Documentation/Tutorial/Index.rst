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


Tutorial
========

The processing in SAV Jpgraph is based on the interpretation of an XML file where tags are
associated with objects (from JpGraph classes or from data, query, file,
marker, template classes). You may split the processing in several XML file or
strings as done in the “sav_jpgraph” extension or have all the XML tags inserted
in the same file.

Due to the interpretation process, the use of XML templating is flexible
but runs slower than the conventional php coding. Therefore a caching system is
available since version 0.2.0 to speed up the rendering.

The tutorial is intended to be a good start to understand how it works.

Table of Contents
-----------------

.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   DesigningABasicXmlTemplateFromAnExample/Index
   SettingUserDataAndMarkerReferences/Index
   GettingDataFromQueries/Index
   DealingWithFunctions/Index
   RepeatingSequencesTheForeachSpecialTag/Index
   DefiningAndUsingAnExternalQueryManager/Index
   ExportingDataInCSV/Index

















