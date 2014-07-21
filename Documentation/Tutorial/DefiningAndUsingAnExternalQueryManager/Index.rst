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


Defining and using an external query manager
--------------------------------------------

In the section “getting data from queries” we have seen how queries
could be used with the “sav\_jpgraph” extension by means of a <query>
... </query> tag in which the SELECT, FROM, WHERE, ... clauses were
defined. In this section we will deal with queries defined by means of
another extension which will be called a query manager. For example,
we will consider the extension “wfqbe” which provides a good solution
to manage general queries.

In “sav\_jpgraph” a special hook was introduced in the class “typo3”
(see “class.typo3.php”) to process the query and deal with errors, if
any. The hook is defined by means of the global variable
TYPO3\_CONF\_VARS (see `http://typo3.org/documentation/document-
library/core-documentation/doc\_core\_api/4.2.0/view/3/4/#id4198557
<http://typo3.org/documentation/document-library/core-
documentation/doc_core_api/4.2.0/view/3/4/#id4198557>`_ ). The
sub\_key “queryManagerClass” is used received the query manager class
in which the two methods “executeQuery” and “getErrorMessage” must be
defined.


Developing a connector for the external query manager
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

You have to develop a connector if it does not already exist. A
connector with “wfqbe” is taken as an example of the implementation.
This connector is called “wfqbe\_savjpgraph” and was developed with
Mauro Lorenzutti who maintains the “wfqbe” extension. It is available
from the TER.

#. Download the extension “wfqbe\_savjpgraph” from the TER.

#. The connector must contain a class with two methods “executeQuery” and
   “getErrorMessage”. For example, in the “wfqbe\_savjpgraph” connector,
   the following class was added in a file
   “hook/class.tx\_wfqbe\_savjpgraph\_hook.php”.

#. The hook must be added in “ext\_localconf.php”. For example, the
   following line was added in the “wfqbe\_savjpgraph” extension.

::

   // Adds a hook for sav_jpgraph
   $TYPO3_CONF_VARS['EXTCONF']['sav_jpgraph']['queryManagerClass']['wfqbe'] = 'EXT:wfqbe_savjpgraph/hook/class.tx_wfqbe_savjpgraph_hook.php:tx_wfqbe_savjpgraph_hook';


Using the query manager
^^^^^^^^^^^^^^^^^^^^^^^

#. Define a query with the query manager. For example, with “wfqbe” you
   need to create a sysfolder in which you will define your query. Assume
   that your new “wfqbe” query has the id “15”.

#. In “sav\_jpgraph” create a query tag in which you will call the
   previous query as follows:

::

   <query id="1">
     <setQueryManager type="wfqbe" uid="15" />
   </query>

It will call the query whose uid=15 defined with the query manager
whose key is “wfqbe”.

