# TYPO3 Privacy

[![Total Downloads](https://poser.pugx.org/jokumer/privacy/downloads.svg)](https://packagist.org/packages/jokumer/privacy)
[![License](https://poser.pugx.org/jokumer/privacy/license.svg)](https://packagist.org/packages/jokumer/privacy)

Manage compliance rules for TYPO3 to improve privacy and to grant the EU General Data Protection Regulation (GPDR)

## Announcement ##

This extension is still on an early state - Work in Progress, so to say. We would like to invite any developer or GDPR experts to contribute to the future developing of the extension. The main goal is to get an extension up running, that will help website owners in the TYPO3 world to be GDPR compliant. Yes, there are many issues involved, and the extension will not fix everyone of them. Focus is on the most important issues, connected to the TYPO3 system.

### Contribute ###

Project home: https://github.com/jokumer/TYPO3-privacy

Bug reports: https://github.com/jokumer/TYPO3-privacy/issues

## Usage and features ##

 * The general approach is to load and manage personal data in TYPO3 (fe_users, be_users, tt_address, etc) and to activate tools for GDPR compliance.
 * Administrator and editors can pseudonymise and/or delete personal data in backend
 * Website users can delete or pseudonymise stored personal data when logged in (Right to be forgotten)
 * Administrator and editors can export personal data in backend
 * Website users can export their stored data when logged in
 * A build in Cookie Concent solution, where website users can accept/decline cookies, and read the website privacy policy.
 * The extension is configurable to handle any table containing personal data through configuration.
 * It is possible to extend extensions to use TYPO3-Privacy features by configuration.

### TYPO3 versions ###

The extension supports TYPO3 CMS v8.x and soon we will support v7.x and v9.x too.

## Background ##

25th of May the EU's General Data Protection Regulation (GDPR) will replace data protection regulations and acts in all member states in EU.

A website owner (data controller) and agencies storing data for anyone else (data processor) has to comply the new set of rules.

Two factors are in focus. The most important one is to bring data protection law in line with how people's data is being used. The Internet allow data processors to invent numerous methods to use (and abuse) people's data, and GDPR aims to correct this.

The second factor is to give organisations more clarity over the legal environment that dictates how they can behave. By making the GDPR law identical in all member states, organisations acting within EU has one set of rules to follow instead of one for each country.

This extension will help website owners in the most important parts of GDPR:
 * The right to be forgotten
 * The right to access data
 * The right to take data elsewhere
 * Explicitly given concent

The extension will not make a website GDPR compliant. As a website owner, you will still have to consider many other issues. Third party services installed on the system might break the GDPR compliance by the existence itself, the page that describe the website privacy policy might inadequate, the website might be storing data unencrypted, and so on.
