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


<query>
-------


================================= ================ =================================================
Tag                               Data type        Description                 
================================= ================ =================================================
query_                            Object           Creates a query object.
select_                           Method           Defines the SELECT clause.
from_                             Method           Defines the FROM clause.
where_                            Method           Defines the WHERE clause.
groupby_                          Method           Defines the GROUP BY clause.
orderby_                          Method           Defines the ORDER BY clause.
limit_                            Method           Defines the LIMIT BY clause.
setQueryManager_                  Method           Defines an external query manager.
================================= ================ =================================================



.. _query:

<query [attribute]> ... </data>
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Creates a query object.

Attribute
  - id = "myQuery"
    Optional attribute but it is requested when using
    reference to this object. The reference will be “myQuery”.


.. _select:

<select>...</select>
^^^^^^^^^^^^^^^^^^^^

Description
  Defines the SELECT clause. See the tutorial for an example.


.. _from:

<from> ... </from>
^^^^^^^^^^^^^^^^^^

Description
    Defines the FROM clause. See the tutorial for an example.


.. _where:

<where> ... </where>
^^^^^^^^^^^^^^^^^^^^

Description
  Defines the WHERE clause. See the tutorial for an example.

  You can use reference in <where> tag. For example, ###marker#myMarker###
  will be replaced by the marker whose "id" is "myMarker".


.. _groupby:

<groupby> ... </groupby>
^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Defines the GROUP BY clause. See the tutorial for an example.


.. _orderby:

<orderby> ... </orderby>
^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Defines the ORDER BY clause.


.. _limit:

<limit> ... </limit>
^^^^^^^^^^^^^^^^^^^^

Description
  Defines the LIMIT clause.


.. _setQueryManager:

<setQueryManager type = "managerName" uid = "integer" [marker1 = "definition" … markerN = "definition"]/>
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Defines an external query manager.

Attributes
  - type = "managerName"
    The external query manager name is defined by
    means of this paramater (e.g. type = "wfqbe")

  - uid = "integer"
    The integer is the uid of the record where the query
    is defined in the external query manager.

    See the section *Defining and using an external query manager* in the
    tutorial.

  - marker1 to markerN are optional attributes which can be used for
    marker subsitution in a query defined with the query manager. The
    definition can either be a reference to an existing maker, e.g.
    "marker#myMarker" or a direct definition, e.g. "myMarker#3". In the
    former case, the query marker ###myMarker### will be replaced by the
    marker whose "id" is "MyMarker" while in the latter case it will be
    replaced by 3.



