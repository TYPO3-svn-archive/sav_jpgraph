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



<typo3>
-------


================================= ================ =================================================
Tag                               Data type        Description                 
================================= ================ =================================================
typo3_                            Object           Creates a typo3 object.
processQuery_                     Method           Processes a query whose "id" is provided by the 
                                                   attribute.
processQueries_                   Method           Processes all defined queries.                     
================================= ================ =================================================


.. _typo3:

<typo3 [attribute]> ... </marker>
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Creates a typo3 object.

Attribute
  - id = "myTypo3"
    Optional attribute but it is requested when using
    reference to this object. The reference will be "myTypo3".


.. _processQuery:

<processQuery attribute />
^^^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Processes a query whose "id" is provided by the attribute.

Attribute:
  - queryId = "myQuery"


.. _processQueries:

<processQueries />
^^^^^^^^^^^^^^^^^^

Description
  Processes all defined queries. Each query is processed only once even
  if there are several calls to <processQueries>.

