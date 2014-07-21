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


<foreach>
---------

The tag <foreach> is not related with a class. It is a special tag
which was introduced to process arrays.


================================= ================ =================================================
Tag                               Data type        Description                 
================================= ================ =================================================
foreach_                          Object           Repeat the sequence inside the tag.
================================= ================ =================================================


.. _foreach:

<foreach [attribute] ref = "myData"”> ... </foreach>
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Repeat the sequence inside the tag. The number of repetitions is the
  size of the reference attribute.

Attribute
  - id = "for1"
    Optional attribute but it is requested when using
    reference to this object. The reference will be “for1”.
         