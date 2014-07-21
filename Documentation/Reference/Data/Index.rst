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


<data>
------


================================= ================ =================================================
Tag                               Data type        Description                 
================================= ================ =================================================
data_                             Object           Creates a data object.
setData_                          Default method   Defines the data. 
setDataFromQuery_                 Method           Defines the data from a query.
setDataFromQueryRow_              Method           Defines the data from a query row.
setDataFromQueryWithGroup_        Method           Defines the data from a query which has 
                                                   a GROUP BY clause.
setArray_                         Method           Defines an array of data.
insertArray_                      Method           Defines an array of data from a reference.
mergeArray_                       Method           Merges arrays.
combineArray_                     Method           Combines arrays having same keys.
utf8Decode_                       Method           Decodes an array
fillMissingData_                  Method           Fills missing data in an array.
================================= ================ =================================================


.. _data:

<data [attribute]> ... </data>
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Creates a data object.

Attributes
  - id = "myData"

  Optional attribute but it is requested when using
  reference to this object. The reference will be "myData".



.. _setData:

<setData attribute />
^^^^^^^^^^^^^^^^^^^^^

Description
  Defines the data.

Attributes
  - value = "5,6,7"

  Use a comma-separated list of values.



.. _setDataFromQuery:

<setDataFromQuery attribute1 attribute2 [attribute3] />
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Defines the data from a query.

Attributes:
  - ref = "query#1"

  An array is expected, in general it is the reference
  to a query.

  - field = "date"

  Field which will be used as the index of the array to
  get the data. Several fields can be used. In this case, they must be
  separated by a comma, e.g. field = "date,count".

  - default = "0,1,2"

  Optional attribute which can be used to set default
  values for the array.



.. _setDataFromQueryRow:

<setDataFromQueryRow attribute1 attribute2 [attribute3] />
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Defines the data from a query row.

Attributes
  - ref = "query#1"

  An array is expected, in general it is the reference
  to a query.

  - fieldList = "date,count"

  Fields which will be used as the index of
  the first row of the query to set the data.

  - default = "0,1,2"

  Optional attribute which can be used to set default
  values for the array.



.. _setDataFromQueryWithGroup:

<setDataFromQueryWithGroup attribute1 attribute2 attribute3 attribute4 [attribute5] />
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Defines the data from a query which has a GROUP BY clause.

Attributes
  - ref = "query#1"
    An array is expected, in general it is the reference
    to a query.

  - field = "date"
    Field which will be used as the index of the row to
    get the data.

  - groupData
    Data which are possible values for the group.

  - groupField
    Field of the GROUP BY clause.

  - default = "0,1,2"
    Optional attribute which can be used to set default
    values for the array.



.. _setDataFromArray:

<setDataFromArray attribute1 [attribute2] />
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Defines the data from an array.

Attributes
  - ref = "data#result"
    An array is expected, in general it is the
    reference to a another data set.

  - index = "2"
    Optional index which will be used to get the data.



.. _setArray:

<setArray attribute1 [attribute2] [attribute3] />
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Defines an array of data.

Attributes
  - value = "5,6,7"
    Use a comma-separated list of values.

  - index = "2"
    Optional index which will be used to set the data
    otherwise data are inserted in the array starting with the index equal
    to 0.

  - asAarray = "1"
    Optional attribute. If set, the data are put into an
    array.



.. _insertArray:

<insertArray attribute/>
^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Defines an array of data from a reference.

Attribute
  - ref = "data#myData"
    An array is expected. In general, it is used with
    accBarPlot or groupBarPlot to insert data which are obtained from
    queries.



.. _mergeArray:

<mergeArray attributes/>
^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Merges arrays.

Attributes
  - references to arrays



.. _combineArray:

<combineArray attribute1 attributes [default]/>
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Combines arrays having same keys.

Attributes
  - The first attribute is the reference to an array containing the keys.
  - Others attributes are the arrays to combine.
  - The last attribute, if not an array, is taken a default value used when
    a key is not found in an array.



.. _utf8Decode:

<utf8Decode attribute/>
^^^^^^^^^^^^^^^^^^^^^^^

Description
  Decodes an array.

Attributes
  - Reference to the array to be decoded.



.. _fillMissingData:

<fillMissingData [default]/>
^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Fills missing data in an array.

Attributes
  - Optional default value. If not set 0 is taken as the default value.















