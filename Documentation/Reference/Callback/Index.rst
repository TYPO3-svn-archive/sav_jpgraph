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


<callback>
----------

================================= ================ =================================================
Tag                               Data type        Description                 
================================= ================ =================================================
callback_                         Object           Creates a callback object
setCallback_                      Default method   Sets the callback method.
setReturn_                        Method           Sets the return data array.
================================= ================ =================================================


.. _callback:

<callback [attribute]> ... </callback>
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Creates a callback object.

Attribute
    - id = "myCallback"

    Optional attribute but it is requested when using
    reference to this object. The reference will be "myCallback".


.. _setCallback:

<setCallback attribute1 attribute2 />
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Sets the callback method.

  Default callback method is provided, therefore calling this method is
  not required in general.

Attributes
  - functionName = "myFunction"

  - className = "myClass"

    Default callback method is provided, therefore calling this method is
    not required in general.


.. _setReturn:

<setReturn attribute />
^^^^^^^^^^^^^^^^^^^^^^^

Description
  Sets the return data array

Attribute
  - ref = "data#myData"

    Reference to the data array which will be used
    for returning values for the callback.



