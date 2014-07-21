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


<marker>
--------


================================= ================ =================================================
Tag                               Data type        Description                 
================================= ================ =================================================
marker_                           Object           Creates a marker object.
setMarker_                        Default Method   Defines the marker.
setMarkerByPieces_                Method           Defines the marker by concatenating the attributes.
================================= ================ =================================================


.. _marker:

<marker [attribute]> ... </marker>
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Creates a marker object.

Attribute
  - id = "myMarker"
    Optional attribute but it is requested when using
    reference to this object. The reference will be “myMarker”.


.. _setMarker:

<setMarker attribute />
^^^^^^^^^^^^^^^^^^^^^^^

Description
  Defines the marker.

Attribute
  - value = "Number of pages created per year"
  
  
.. _setMarkerByPieces:

<setMarkerByPieces attribute1 .. AttributeN />
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Defines the marker by concatenating the attributes.

Attributes
  - part1 = "Number of"
  - part2 = " pages "
  - part3 = "created per year"
    It generates the marker "Number of pages created per year".
    Using \\n in a string generates a newline break.



