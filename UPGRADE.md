# Upgrade notices

## From contao-privacy-bundle

This is a major refactoring of the privacy bundle. The following changes are made:
- removed privacy form module
- removed reference types
- changed the way how adding entries from code
- changed the data collected

### Maildrum

#### Mailding lists

Fields `addUnsubscribePrivacyProtocolEntry,unsubscribePrivacyProtocolEntryArchive,unsubscribePrivacyProtocolEntryType,unsubscribePrivacyProtocolEntryDescription` are not supported anymore, use `privacyProtocolArchive` instead.

#### Frontend modules

Privacy protocol entries in frontend modules are not supported anymore, set them in the mailing list instead.
