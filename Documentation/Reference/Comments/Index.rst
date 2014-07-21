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


<comments>
----------


================================= ================ =================================================
Tag                               Data type        Description                 
================================= ================ =================================================
comments_                         None             Creates comments about overloaded attributes.
languageKey_                      None             Defines the label associated with the 
                                                   overloaded attributes.
================================= ================ =================================================


.. _comments:

<comments> ... </comments>
^^^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Creates comments about overloaded attributes. Comments are associated
  with overloaded attributes and are displayed in the BE flexform.


.. _languageKey:

<languageKey index = "..."> <label index = "..."> ... </label> </languageKey>
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Description
  Defines the label associated with the overloaded attributes. Use
  "tag#attribute" for the index. The language key makes it possible to
  have localization labels for the comments in the flexform. Use the
  conventional TYPO3 language keys for the index.















