============================================================
Documentation of breaking changes, deprecations and features
============================================================


Motivation and goals
====================

Spreading information about important core changes has been a problematic issue ever since. With the switch to the
new release cycle with version 7 of the TYPO3 CMS core this situation should be improved.

A dedicated changelog of important changes is established to inform users, developers and other core related
teams or projects:

- Overview for documentation team which changes trigger documentation changes.

- Overview for Release Managers and other "Spread the word" related works on important changes.

- Hints for extension developers, integrators and project developers whose own code areas may need adjustments on core updates.

- Standardized format for easy usage in scripts like a core migration or release notes system.

This new structure also replaces the NEWS.md file.

Different changelog types
=========================

A changelog handles one of these change types:

- Breaking change: A patch moved or removed a specific part of core functionality that may break extensions if they use this part. Removal of deprecated code or an interface change are good examples of this type.

- Deprecation: A patch deprecates a certain core functionality for a planned removal.

- Feature: A patch adds new functionality.

- Important: Any other important message.

Casual bug fixes do not need changelog files, but every change that may be of special interest for extension developers
or documentation writers should receive an entry. The changelog file must be provided as part of the patch that
introduces the change.


Location
========

New changelog files should be added to the "master" directory. If a version is to be released, all files in this directory
will be moved to a directory that is named after the release number. This way it can be easily seen which change was
introduced in which released core version.


Filename convention
===================

<type>-<forgeIssueNumber>-<UpperCamelCaseDescription>.rst


File content
============

Like other documentation, changelog files are done in ReST, see `TYPO3 wiki ReST syntax`_ for more details.

- All types contain a "Description" section that should give a short summary on which core part was affected by the change.

- All types contain an "Impact" section that describes the possible impact of a change. An example is "Frontend output may change", "Configuration of xy is easier" or "Backend will throw a fatal error".

- Types "Deprecation" and "Breaking" contain an "Affected installations" section that describes when and if a TYPO3 instance is affected by a change. Example: "Extension xy is in use" or "TypoScript functionality xy is used" or "System is based on PHP 5.3".

- Types "Deprecation" and "Breaking" contain a "Migration" section to describe best practices on how to cope with a specific change.

.. _TYPO3 wiki ReST syntax: http://wiki.typo3.org/ReST_Syntax

Tagging
=======

To provide the possibility to filter RST files by topics, it is mandatory to equip every RST file with at least two tags. As a rule of thumb a file should have no more than five tags. Please limit yourself to the list provided below. If you are in dearly need to introduce a new tag, you must also add it to the list (and explain it) in this file as a reference for everyone.

List of all possible tags:

- TypoScript - Changes that imply or introduce alterations to some TypoScript settings or modify the behavior of TypoScript itself.

- Fluid - Changes that alter behavior of Fluid like introducing new tags or modifying already established ones.

- Ext:xyz - Changes on extension xyz. Please refer to this tag only when changing system extensions.

- TCA - Every change related to TCA.

- Database - Changes that modify behavior of the database abstraction or introduces or removes new fields.

- LocalConfiguration - Changes that affect the LocalConfiguration.php or the subordinated AdditionalConfiguration.php

- JavaScript - Modifying or introducing JavaScript.

- PHP-API - Implementations of mandatory changes of the PHP-API.

- Page TS - Changes or modifications on the Page TS or the behavior of this field.

- User TS - Changes of modifications on the User TS or the behavior of this field.

- Frontend - Changes that will affect the behavior or rendering of the TYPO3 Frontend.

- Backend - Changes that will affect the behavior or rendering of the TYPO3 Backend.
