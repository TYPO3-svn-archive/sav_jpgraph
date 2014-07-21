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


Changelog
=========

.. tabularcolumns:: |r|p{13.7cm}|

=======  ===========================================================================
Version  Changes
=======  ===========================================================================
1.0.1    - Bug when calling context sensitive help corrected. 
         - Better generation of the reference section.
         
1.0.0    - Caching system added when using queries.
         - Exporting data graphs in CSV added.
         - Documentation converted to the reStructuredText format.
         
0.1.1    - Improvement in the query error processing.
         - Attribute2 in <setDataFromArray> is now optional.
         - XLIFF files added for translation.

0.1.0    - Code reorganized and compatible with TYPO3 6.0.
         - New XML tag <callback> added in order to use callbacks in plots (see
           map.xml for an example).
         - Attributes added to <setQueryManager> in order to manage markers in
           queries.
         - New attributes to manage data.

0.0.15   - JpGraph Library updated to v3.0.7 released on 11/01/2010.
         - New XML tag <setQueryManager> was added in order to use queries
           defined by means of a query manager. A new section in the tutorial was
           added to explain this new feature. A connector, called
           “wfqbe\_savjpgraph”, was developed with Mauro Lorenzutti for the
           “wfqbe” extension. It is used to illustrate this new feature and is
           available in the TER.
         - Paper presented to the T3CON09 in Frankfurt, Sept. 2009, added in
           doc/.

0.0.14   - JpGraph Library updated to v3.0.6 released on 10/10/2009.

0.0.13   - JpGraph Library updated to v3.0.5 released on 03/10/2009.

0.0.12   - New feature added. Overloaded tags are automatically displayed in the
           BE flexform. By double-clicking on a tag, it is inserted in the
           related section.

0.0.11   - Bug when using TYPO3 4.3 fixed (Bug #4193).         
         - JpGraph Library updated to v3.0.3 released on 02/09/2009.         
         - Two new templates added (groupBarPlot.xml and accBarPlot.xml)

0.0.10   - JpGraph Library updated to v3.0.2 released on 01/08/2009.

0.0.9    - JpGraph Library updated to v3.0.1 released on 24/07/2009.

0.0.8    - Small correction in the code to improve the use of php constants.
         - New template radarex7.xml added

0.0.7    - The extension runs as a USER plugin except when queries are used. In
           this case the extension runs as a USER\_INT plugin. The change is
           performed using a XCLASS of the class tslib\_cObj based on an idea
           taken from Dmitry Dulepov (see See the TYPO3 bugtracker #0008985).
         - The class xmGraph in class.xmlgraph.php was slightly modified to take
           into account multiple required files (e.g. PiePlot3D where
           jpgraph\_pie.php and jpgraph\_pie3d.php are required).
         - New template example27.1.xml was added.

0.0.6    - Improve the localization for translation purpose (feature #3199).

0.0.5    - Translations available through the translation server.

0.0.4    - <typo3> tag added to process queries in other extensions.

0.0.3    - Configuration added for the TTF directory.
         - Method setArrayFromQuery added in <data>.
         - CSH added in English and French.

0.0.2    - <foreach> tag added to process sequences (see the example with
           GanttPlot added in the tutorial).

0.0.1    - 1st public release
=======  ===========================================================================


