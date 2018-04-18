# bid4myjob
Bid4MyJob

Welcome to the github repository for bid4myjob, a web based application allowing users to post jobs, with potential bidders
competing to secure the job by submitting a bid with varying requirements.

Based on a HTML5 theme called Listeo, which forms the basis of the site. (Look and feel)
Further modifactions were made in PHP, JavaScript, MySQL transoforming the static site into a fully interactive application.
The site is responsive, fast loading and attractive.

Current features:

Registration

Login

Some error handling including sanitizing of user input when registering and posting jobs (doesn't look nice but works)

Dashboard displays credits and recent transactions

Escrow payment system

Users can post jobs

Users can bid on jobs

Job poster can choose the winner

Job poster can mark a job as complete

Payment is only completed when the job is marked as complete

** TO DO **

Javascript, on click of submit of mark compelte, javascript function which sets display:none to block of div 
after insert button "Are you sure? This will send _ credits to _ and close this job."

creating transactions that aren't connected to a job, similar code to mark-complete.php but without scraping bid details, instead attach
userId to button on their profile "send money". Box appears, with form, asks how much, recipient hidden field, sender session ID. 
send-money.php

my profile, change address, password, email.

confirmed field in user? when registering, create hash of username.
email this link to the email address = confirm-user.php?link=H49egnaf3t0ETNqG9meg
confirm.php GET link
if link==hash(username)
update set confirmed true!

in users table, create field called "forgotten-hash"
it's empty. when you forget password, type in email address or username.
this then generates a hash of the old password (?)
forgotten-pass.php?forgot-code=3etiwr83QTH492TRG

get forgot code, if it equals hash of the old password, create a small form with "new password" and "confirm new password"
on submit

On job page. If you are winnerID and job=complete, then you are able to review the poster. Select from PosterReviews where 
jobId=jobID, if there is more than zero than you have posted a review and cannot post again.

On job page. If you are posterID and job=complete, then you are able to review the bidder. Select from BidderReviews where 
jobId=jobID, if there is more than zero than you have posted a review and cannot post again.

user-exists.php?id=_ (AJAX request during registration to check if a username exists) returns JSON "username:_","taken:f/t"
also include in user-exists.php some usernames that are not allowed 
