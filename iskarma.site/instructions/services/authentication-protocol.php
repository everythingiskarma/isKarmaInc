1. Authentication Inputs

  a. EMAIL
    Initially the login page has only one input box for the email.
    It can handle both login and new registration.
    After user enters a valid email it is sent via jquery/ajax post request to the authenticator script 'getSiteAuth.php'.

  b. OTP
    After email verification and otp generation the 'getSiteAuth.php' sends response with values of `uid` and `type` which is parsed by jquery and it populates an otp input field with a submit button for verification.
    the submit button will have values `uid` and `type` sent by the script like so:
    <input type="number" id="otp" alt="enter the 6 digit otp sent to your email address" maxlength="6">
    <a class="button" type="{$type}" uid="{$uid}">Verify OTP</a>

  c. logout
    when user clicks logout button an Ajax/jQuery post request is sent to the script which will contain the `uid` of the logged in user.
    upon recieving the request the script will set the value of field `loggedin` in `users` table to '0' and destroy the session variable $_SESSION['loggedin'].

2. authenticator script (getSiteAuth.php)
  based on the parameters passed in the post request the script performs two functions
  Function TYPE1 (email authentication)

  - upon recieveing request connects to the database and checks two fields `email` and `verified` in the `users` table.
  - if the email is not found in `users` table create a new account (apply scenario 'a')
  - if the email is found (apply scenario 'b').

  a. create new account

    step1.
      create new entry in `gatekeeper` table.
      this is its table structure.
      CREATE TABLE `iskarma`.`gatekeeper` ( /* */
        `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, /*  */
        `uid` VARCHAR(255) UNIQUE NOT NULL, /*  */
        `email` VARCHAR(255) UNIQUE NOT NULL, /*  */
        `domain` VARCHAR(255) NOT NULL, /*  */
        `verified` INT(1) NOT NULL DEFAULT '0', /*  */
        `created` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP, /*  */
      );
      it is used to verify accounts before adding them to the users table to prevent spamming and bloating the main `users` table.
      new entry - store values of `email` & `domain` (recieved in the ajax post), `uid` (auto generated 16 character UNIQUE id by the script) and set value of `verified` to `0`.

    step2.
      after creating a new entry in `gatekeeper` create an entry in `otps` table.
      here is its table structure
      CREATE TABLE `iskarma`.`otps` (
        `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, /*  */
        `uid` VARCHAR(255) UNIQUE NOT NULL, /*  */
        `type` INT(1), /* '1' otp for verified registered accounts, '0' otp for unverified gatekeeper accounts */
        `issued` INT(6), /*  */
        `date_issued` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP, /*  */
        `verified` INT(1) NOT NULL DEFAULT '0', /*  */
        `date_verified` DATE, /*  */
      );

      generate a 6 digit random otp and perform 2 actions with it.
      -> store the otp in the `issued` field in  the `otps` table and set the value of field `type` to `0` along with the `uid` generated while creating the gatekeeper account.
      -> send an email to the user with the generated `otp`.

  b. already registered

    step1.
      - get the `uid` from the `users` table corresponding to the registered `email`.
      - generate a 6 digit otp.
      - make an entry in the `otps` table. set value of fields `uid` (uid of the email), `issued` (6 digit otp) and `type` (set value to '1')
    step2.
      - send an email containing the otp to the user

  REQUEST TYPE 2 (otp verification)

    Send Ajax/jQuery POST Request:
      when user enters otp, another ajax/jquery post request is sent to 'getSiteAuth.php'. this post request also sends the `uid` and `otp` type of the user (which were set as attributes of the submit button).

    Check for Entry in `otps` Table:
      the script will first check the `otps` table for an entry using the `uid` of the user.

      a. no entry found
        if an entry does not exist it will send a response to jQuery that will reset the form and prompt the user to enter the email again to generate another otp.

      b. entry found
        if an entry is found it will check number of failed attempts for the last entry. if the attempts are more than 5 then the script will send an ajax response to reset the form and prompt the user to request another otp as that request has exceeded maximum allowed failed attempts.

        if the failed attempts are less than 5 the script will continue to verify the otp.

        if the otp does not match. an ajax response from the script informs the user that the otp was incorrect and adds the `otp_attemps` count by 1 in the `otps` table and prompt the user about incorrect otp and request to try entering the otp again.

        if the `otp` entered by the user matches the entry in the `otps` table, the script will continue to check the type of the otp.

        if the otp was generated for the gatekeeper (i.e `type` = '0'), then in the `gatekeeper` table it will assign value `1` to the `verified` column for the entry matching the `uid` and continue to create a verified account entry into the `users` table.


        here is the `users` table
        CREATE TABLE `iskarma`.`users` (
          `id` INT AUTO_INCREMENT PRIMARY KEY, /*  */
          `uid` VARCHAR(255) UNIQUE NOT NULL, /*  */
          `email` VARCHAR(255) UNIQUE NOT NULL, /*  */
          `firstname` VARCHAR(255) NOT NULL DEFAULT 'firstname', /*  */
          `lastname` VARCHAR(255) NOT NULL DEFAULT 'lastname', /*  */
          `phone` VARCHAR(20), /*  */
          `loggedin` INT(1) DEFAULT 0, /*  */
          `created` DATETIME, /*  */
          `updated` DATETIME, /*  */
        );

        this entry will set values for `uid` & `email` set value for `loggedin` as `1` and create a session variable $_SESSION['loggedin']. user is now verified and signed into the account and the script will send a response to jQuery/ajax to show the user's profile.

        if the otp was generated for the `users` (i.e `type` = '1'), then the script will set the value of field `loggedin` as '1' and create a session variable $_SESSION['loggedin']. user is now signed into the account.

    if it matches then it checks the otp type.

    Type(0). Unverified gatekeeper account
      - this otp was generated by the `gatekeeper` for new user registration.

    Type(1). Verified Registered account
      - this otp was generated by the `users` for registered user login

    if otp matches it sets `loggedin` field in the `users` table to value '1' (default or logout is 0).
