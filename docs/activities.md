# Activities
Activities will be one of the main features of the new website.
Members should be able to register for an activity.

Each activity has a **title**, **description**, **location** and **date /
time**.
Optionally an activity can be paid.

Activities can be categorized into: *social*, *careers* and *education*.

## events
The following is a list of basic events that will be implemented. These do not
include events from integrating the activities with registrations, promos etc.

- ActivityPlanned
- ActivityPublished
- ActivityCategorized
- ActivityRescheduled
- ActivityLocationChanged
- ActivityCancelled
- ActivityPricechanged
- ActivityDetailsChanged // title, description

## Paid activities
Some activities might be paid

## Registration period
By default an activity's registration period stops after the end of the activity.
Each member can register for an activity.
When an activity is payed, the member will pay.

## Promo period
An activity can have a promo period which can be used to display posters and
images on the tvunit.
When a drafted activity is almost ready for publishing, but it needs some
additional posters etc then there should be an option for
SendingDraftToPromoTeam (to representatie)

## Photo album
If pictures were taken we should be able to link the activity to an album.

## Recurring activities
Some activities are recurring yearly, we should be able to show this somewhere.

### Technical side note:
This could be implemented as a separate aggregate root
Or add a predecessor field

## Emails
Custom email message

## Misc
- Sending emails
- Telegram / sms?
- Potentially some activities might need a resume. We should grab this from the
member's profile page.
- Templated events on the admin panel
- Synchronization with google calendar
