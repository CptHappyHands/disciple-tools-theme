<?php

( function () {

    $contact = Disciple_Tools_Contacts::get_contact( get_the_ID(), true );
    $channel_list = Disciple_Tools_Contacts::get_channel_list();
    $current_user = wp_get_current_user();
    $contact_fields = Disciple_Tools_Contacts::get_contact_fields();
    $custom_lists = dt_get_option( 'dt_site_custom_lists' );

    function dt_contact_details_status( $id, $verified, $invalid ){
        ?>
        <img id="<?php echo esc_html( $id )?>-verified" class="details-status" style="display:<?php echo esc_html( $verified )?>" src="<?php echo esc_html( get_template_directory_uri() . '/assets/images/verified.svg' )?>" />
        <img id="<?php echo esc_html( $id ) ?>-invalid" class="details-status" style="display:<?php echo esc_html( $invalid )?>" src="<?php echo esc_html( get_template_directory_uri() . '/assets/images/broken.svg' )?>" />
        <?php
    }
    function dt_contact_details_edit( $id, $field_type, $remove = false ){
    ?>
        <ul class='dropdown menu' data-click-open='true'
            data-dropdown-menu data-disable-hover='true'
            style='display:inline-block'>
            <li>
                <button class="social-details-options-button">
                    <img src="<?php echo esc_html( get_template_directory_uri() . '/assets/images/menu-dots.svg' )?>" style='padding:3px 3px'>
                </button>
                <ul class='menu'>
                    <li>
                        <button class='details-status-button field-status verify'
                                data-status='valid'
                                data-id='<?php echo esc_html( $id )?>'>
                            <?php esc_html_e( 'Valid', 'disciple_tools' )?>
                        </button>
                    </li>
                    <li>
                        <button class='details-status-button field-status invalid'
                                data-status="invalid"
                                data-id='<?php echo esc_html( $id )?>'>
                            <?php esc_html_e( 'Invalid', 'disciple_tools' )?>
                        </button>
                    </li>
                    <li>
                        <button class='details-status-button field-status'
                                data-status="reset"
                                data-id='<?php echo esc_html( $id ) ?>'>
                            <?php esc_html_e( 'Unconfirmed', 'disciple_tools' )?>
                        </button>
                    </li>
                    <?php if ($remove){ ?>
                        <li>
                            <button class='details-remove-button delete-method'
                                    data-field='<?php echo esc_html( $field_type ) ?>'
                                    data-id='<?php echo esc_html( $id ) ?>'>
                                <?php esc_html_e( 'Delete item', 'disciple_tools' )?>
                            <button>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        </ul>
    <?php } ?>

    <?php if (isset( $contact->fields["requires_update"] ) && $contact->fields["requires_update"]["key"] === "yes"){ ?>
    <div class="update-needed callout alert small-12 cell">
        <button class="update-needed close-button" aria-label="Close alert" type="button" data-close>
            <span aria-hidden="true">&times;</span>
        </button>
        <h4><?php esc_html_e( 'This contact needs an update', 'disciple_tools' )?>.</h4>
        <p><?php esc_html_e( 'It has been a while since this contact seen an update. Please do so', 'disciple_tools' )?>.</p>
    </div>
    <?php } ?>
    <?php if (isset( $contact->fields["overall_status"] ) &&
        $contact->fields["overall_status"]["key"] == "assigned" &&
        $contact->fields["assigned_to"]['id'] == $current_user->ID
    ) { ?>
    <div id="accept-contact" class="callout alert small-12 cell">
        <h4 style="display: inline-block"><?php esc_html_e( 'This contact has been assigned to you', 'disciple_tools' )?></h4>
        <span class="float-right">
            <button onclick="details_accept_contact(<?php echo get_the_ID() ?>, true)" class="button small"><?php esc_html_e( 'Accept', 'disciple_tools' )?></button>
            <button onclick="details_accept_contact(<?php echo get_the_ID() ?>, false)" class="button small alert"><?php esc_html_e( 'Decline', 'disciple_tools' )?></button>
        </span>
    </div>
    <?php } ?>


    <?php if (current_user_can( "assign_any_contacts" )){?>
    <section class="small-12 cell">
        <div class="bordered-box">
            <p class="section-header"><?php esc_html_e( 'Dispatch Section', 'disciple_tools' )?></p>
            <div class="grid-x grid-margin-x">
                <div class="medium-6 cell">
                    <div class="section-subheader"><?php esc_html_e( 'Assigned To', 'disciple_tools' )?>:
                        <span class="current-assigned">
                            <?php
                            if ( isset( $contact->fields["assigned_to"] ) ){
                                echo esc_html( $contact->fields["assigned_to"]["display"] );
                            } else {
                                esc_html_e( 'Nobody', 'disciple_tools' );
                            }
                            ?>
                        </span>
                    </div>
                    <div class="assigned_to">
                        <input class="typeahead" type="text" placeholder="Type to search users">
                    </div>
                </div>
                <div class="medium-6 cell">
                    <div class="section-subheader"><?php esc_html_e( 'Set Unassignable', 'disciple_tools' )?>:</div>
                    <select id="reason_unassignable" class="select-field">
                        <?php
                        foreach ( $contact_fields["reason_unassignable"]["default"] as $reason_key => $reason_value ) {
                            if ( isset( $contact->fields["reason_unassignable"] ) &&
                                $contact->fields["reason_unassignable"]["key"] === $reason_key ){
                                    echo '<option value="'. esc_html( $reason_key ) . '" selected>' . esc_html( $reason_value ) . '</option>';
                            } else {
                                echo '<option value="'. esc_html( $reason_key ) . '">' . esc_html( $reason_value ). '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="medium-6 cell">
                    <div class="section-subheader"><?php esc_html_e( 'Update Needed', 'disciple_tools' )?></div>
                    <div class="switch tiny">

                        <input class="switch-input update-needed" id="update-needed" type="checkbox" name="update-needed"
                        <?php echo esc_html( ( isset( $contact->fields["requires_update"] ) && $contact->fields["requires_update"]["key"] == "yes" ) ? 'checked' : "" ) ?>>
                        <label class="switch-paddle update-needed" for="update-needed">
                            <span class="show-for-sr"><?php esc_html_e( 'Update Needed', 'disciple_tools' )?></span>
                            <span class="switch-active" aria-hidden="true"><?php esc_html_e( 'Yes', 'disciple_tools' )?></span>
                            <span class="switch-inactive" aria-hidden="false"><?php esc_html_e( 'No', 'disciple_tools' )?></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php } ?>

    <section class="cell">
        <div class="bordered-box">
            <span id="contact-id" style="display: none"><?php echo get_the_ID()?></span>

            <div class="item-details-header-row">
                <i class="fi-torso large"></i>
                <span class="item-details-header details-list title" ><?php the_title_attribute(); ?></span>
                <input id="title" class="text-field details-edit" value="<?php the_title_attribute(); ?>">
                <span class="button alert label">
                    <?php esc_html_e( 'Status', 'disciple_tools' )?>: <span id="overall-status"><?php echo esc_html( $contact->fields["overall_status"]["label"] ) ?></span>
                    <span id="reason">
                        <?php
                        if ( $contact->fields["overall_status"]["key"] === "paused" &&
                            isset( $contact->fields["reason_paused"] )){
                            echo '(' . esc_html( $contact->fields["reason_paused"]["label"] ) . ')';
                        } else if ( $contact->fields["overall_status"]["key"] === "closed" &&
                            isset( $contact->fields["reason_closed"] )){
                            echo '(' . esc_html( $contact->fields["reason_closed"]["label"] ) . ')';
                        } else if ( $contact->fields["overall_status"]["key"] === "unassignable" &&
                            isset( $contact->fields["reason_unassignable"] )){
                            echo '(' . esc_html( $contact->fields["reason_unassignable"]["label"] ) . ')';
                        }
                        ?>
                    </span>
                </span>
                <?php $status = $contact->fields["overall_status"]["key"] ?? ""; ?>
                <button data-open="pause-contact-modal"
                        class="button trigger-pause"
                        style="display:<?php echo ($status != "paused" ? "inline" : "none"); ?>">
                    <?php esc_html_e( 'Pause', 'disciple_tools' )?>
                </button>
                <button class="button trigger-unpause make-active"
                        style="display:<?php echo ($status === "paused" ? "inline" : "none"); ?>">
                    <?php esc_html_e( 'Un-pause', 'disciple_tools' )?>
                </button>
                <button data-open="close-contact-modal"
                        class="button trigger-close"
                        style="display:<?php echo ($status != "closed" ? "inline" : "none"); ?>">
                    <?php esc_html_e( 'Close', 'disciple_tools' )?>
                </button>
                <button class="button trigger-unclose make-active"
                        style="display:<?php echo ($status === "closed" ? "inline" : "none"); ?>">
                    <?php esc_html_e( 'Re-open', 'disciple_tools' )?>
                </button>
                <button class="float-right" id="edit-details">
                    <i class="fi-pencil"></i>
                    <span id="edit-button-label"><?php esc_html_e( 'Edit', 'disciple_tools' )?></span>
                </button>
            </div>

            <div class="reveal" id="close-contact-modal" data-reveal>
                <h1><?php esc_html_e( 'Close Contact', 'disciple_tools' )?></h1>
                <p class="lead"><?php esc_html_e( 'Why do you want to close this contact?', 'disciple_tools' )?></p>

                <select id="reason-closed-options">
                    <?php
                    foreach ( $contact_fields["reason_closed"]["default"] as $reason_key => $reason_label ) {
                    ?>
                        <option value="<?php echo esc_attr( $reason_key )?>"> <?php echo esc_html( $reason_label )?></option>
                    <?php
                    }
                    ?>
                </select>
                <button class="button button-cancel clear" data-close aria-label="Close reveal" type="button">
                    <?php esc_html_e( 'Cancel', 'disciple_tools' )?>
                </button>
                <button class="button" type="button" id="confirm-close" onclick="close_contact(<?php echo get_the_ID()?>)">
                    <?php esc_html_e( 'Confirm', 'disciple_tools' )?>
                </button>
                <button class="close-button" data-close aria-label="Close modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="reveal" id="pause-contact-modal" data-reveal>
                <h1><?php esc_html_e( 'Pause Contact', 'disciple_tools' )?></h1>
                <p class="lead"><?php esc_html_e( 'Why do you want to pause this contact?', 'disciple_tools' )?></p>

                <select id="reason-paused-options">
                    <?php
                    foreach ( $contact_fields["reason_paused"]["default"] as $reason_key => $reason_label ) {
                    ?>
                        <option value="<?php echo esc_attr( $reason_key )?>"
                            <?php if ( ($contact->fields["reason_paused"]["key"] ?? "") === $reason_key ){echo "selected";} ?>>
                            <?php echo esc_html( $reason_label )?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
                <button class="button button-cancel clear" data-close aria-label="Close reveal" type="button">
                    <?php esc_html_e( 'Cancel', 'disciple_tools' )?>
                </button>
                <button class="button" type="button" id="confirm-pause" onclick="pause_contact(<?php echo get_the_ID()?>)">
                    <?php esc_html_e( 'Confirm', 'disciple_tools' )?>
                </button>
                <button class="close-button" data-close aria-label="Close modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="reason-fields grid-x details-edit">
                <?php $status = $contact->fields["overall_status"]["key"] ?? ""; ?>
                <!-- change reason paused options-->
                <div class="medium-6 reason-field reason-paused" style="display:<?php echo ($status === "paused" ? "inherit" : "none"); ?>">
                    <div class="section-subheader"><?php echo esc_html( $contact_fields["reason_paused"]["name"] ) ?></div>
                    <select class="status-reason" data-field="<?php esc_html_e( "reason_paused", 'disciple_tools' ) ?>" >
                        <?php
                        foreach ( $contact_fields["reason_paused"]["default"] as $reason_key => $reason_label ) {
                        ?>
                            <option value="<?php echo esc_attr( $reason_key )?>"
                                <?php if ( ($contact->fields["reason_paused"]["key"] ?? "") === $reason_key ){echo "selected";}?> >
                                <?php echo esc_html( $reason_label )?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <!-- change reason closed options-->
                <div class="medium-6 reason-field reason-closed" style="display:<?php echo ($status === "closed" ? "inherit" : "none"); ?>">
                    <div class="section-subheader"><?php echo esc_html( $contact_fields["reason_closed"]["name"] ) ?></div>
                    <select class="status-reason" data-field="<?php esc_html_e( "reason_closed", 'disciple_tools' ) ?>" >
                        <?php
                        foreach ( $contact_fields["reason_closed"]["default"] as $reason_key => $reason_label ) {
                            ?>
                            <option value="<?php echo esc_attr( $reason_key )?>"
                                <?php if ( ($contact->fields["reason_closed"]["key"] ?? "") === $reason_key ){echo "selected";}?> >
                                <?php echo esc_html( $reason_label )?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <!-- change reason unassignable options-->
                <div class="medium-6 reason-field reason-unassignable" style="display:<?php echo ($status === "unassignable" ? "inherit" : "none"); ?>">
                    <div class="section-subheader"><?php echo esc_html( $contact_fields["reason_unassignable"]["name"] ) ?></div>
                    <select class="status-reason" data-field="<?php esc_html_e( "reason_unassignable", 'disciple_tools' ) ?>" >
                        <?php
                        foreach ( $contact_fields["reason_unassignable"]["default"] as $reason_key => $reason_label ) {
                            ?>
                            <option value="<?php echo esc_attr( $reason_key )?>"
                                <?php if ( ($contact->fields["reason_unassignable"]["key"] ?? "") === $reason_key ){echo "selected";}?> >
                                <?php echo esc_html( $reason_label )?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="display-fields">
                <div class="grid-x grid-margin-x">

                    <!--Phone-->
                    <!--Email-->
                    <div class="xlarge-4 large-6 medium-6 small-12 cell">
                        <div class="section-subheader"><?php echo esc_html( $channel_list["phone"]["label"] ) ?>
                            <button data-id="phone" class="details-edit add-button">
                                <img src="<?php echo esc_html( get_template_directory_uri() . '/assets/images/small-add.svg' ) ?>"/>
                            </button>
                        </div>
                        <ul class="phone details-list">
                            <?php
                            if (sizeof( $contact->fields["contact_phone"] ?? [] ) === 0 ){
                                ?> <li id="no-phone"><?php esc_html_e( "No phone set", 'disciple_tools' ) ?></li> <?php
                            }
                            foreach ($contact->fields["contact_phone"] ?? [] as $field => $value){
                                $verified = isset( $value["verified"] ) && $value["verified"] === true ? "inline" :"none";
                                $invalid = isset( $value["invalid"] ) && $value["invalid"] === true ? "inline" :"none";
                                ?>
                                <li class="<?php echo esc_html( $value["key"] ) ?>">
                                    <span class="details-text"><?php echo esc_html( $value["value"] ); ?></span>
                                    <?php dt_contact_details_status( $value["key"], $verified, $invalid );  ?>
                                </li>
                            <?php } ?>
                        </ul>
                        <ul id="phone-list" class="details-edit">
                        <?php
                        if ( isset( $contact->fields["contact_phone"] )){
                            foreach ($contact->fields["contact_phone"] ?? [] as $value){
                                $verified = isset( $value["verified"] ) && $value["verified"] === true;
                                $invalid = isset( $value["invalid"] ) && $value["invalid"] === true;
                                ?>
                                <li class="<?php echo esc_attr( $value["key"], 'disciple_tools' )?>">
                                    <input id="<?php echo esc_attr( $value["key"], 'disciple_tools' )?>"
                                           value="<?php echo esc_attr( $value["value"], 'disciple_tools' )?>"
                                           class="contact-input">
                                    <?php dt_contact_details_edit( $value["key"], "phone", true ) ?>
                                </li>

                            <?php }
                        }?>
                        </ul>

                        <div class="section-subheader"><?php echo esc_html( $channel_list["email"]["label"] ) ?>
                            <button data-id="email" class="details-edit add-button">
                                <img src="<?php echo esc_html( get_template_directory_uri() . '/assets/images/small-add.svg' ) ?>"/>
                            </button>
                        </div>
                        <ul class="email details-list">
                            <?php
                            if (sizeof( $contact->fields["contact_email"] ?? [] ) === 0 ){
                                ?> <li id="no-email"><?php esc_html_e( "No email set", 'disciple_tools' ) ?></li> <?php
                            }
                            foreach ($contact->fields["contact_email"] ?? [] as $field => $value){
                                $verified = isset( $value["verified"] ) && $value["verified"] === true ? "inline" :"none";
                                $invalid = isset( $value["invalid"] ) && $value["invalid"] === true ? "inline" :"none";
                                ?>
                                <li class="<?php echo esc_html( $value["key"] ) ?>">
                                    <?php echo esc_html( $value["value"] );
                                    dt_contact_details_status( $value["key"], $verified, $invalid ); ?>
                                </li>
                            <?php }?>
                        </ul>
                        <ul id="email-list" class="details-edit">
                            <?php
                            if ( isset( $contact->fields["contact_email"] )){
                                foreach ($contact->fields["contact_email"] ?? [] as $value){
                                    $verified = isset( $value["verified"] ) && $value["verified"] === true;
                                    $invalid = isset( $value["invalid"] ) && $value["invalid"] === true;
                                    ?>
                                    <li>
                                        <input id="<?php echo esc_attr( $value["key"], 'disciple_tools' )?>" value="<?php echo esc_attr( $value["value"], 'disciple_tools' ) ?>" class="contact-input">
                                        <?php dt_contact_details_edit( $value["key"], esc_html__( "email", 'disciple_tools' ) , true ) ?>
                                    </li>
                                    <?php
                                }
                            }?>
                        </ul>

                    </div>
                    <!-- Locations -->
                    <!-- Assigned To -->
                    <div class="xlarge-4 large-6 medium-6 small-12 cell">
                        <div class="section-subheader"><?php esc_html_e( "Locations", 'disciple_tools' ) ?></div>
                        <ul class="locations-list">
                            <?php
                            foreach ($contact->fields["locations"] ?? [] as $value){
                                ?>
                                <li class="<?php echo esc_html( $value->ID )?>">
                                    <a href="<?php echo esc_url( $value->permalink ) ?>"><?php echo esc_html( $value->post_title ) ?></a>
                                    <button class="details-remove-button connection details-edit"
                                            data-field="locations" data-id="<?php echo esc_html( $value->ID ) ?>"
                                            data-name="<?php echo esc_html( $value->post_title ) ?>">
                                        <?php esc_html_e( "Remove", 'disciple_tools' ) ?>
                                    </button>
                                </li>
                            <?php }
                            if (sizeof( $contact->fields["locations"] ) === 0){
                                ?> <li id="no-location"><?php esc_html_e( "No location set", 'disciple_tools' ) ?></li><?php
                            }
                            ?>
                        </ul>
                        <div class="locations details-edit">
                            <input class="typeahead" type="text" placeholder="Type to search locations">
                        </div>

                        <div class="section-subheader"><?php esc_html_e( 'Assigned to', 'disciple_tools' )?>
                            <span class="assigned_to details-edit">:
                        </span> <span class="assigned_to details-edit current-assigned">:</span> </div>
                        <ul class="details-list assigned_to">
                            <li class="current-assigned">
                                <?php
                                if ( isset( $contact->fields["assigned_to"] ) ){
                                    echo esc_html( $contact->fields["assigned_to"]["display"] );
                                } else {
                                    esc_html_e( 'None Assigned', 'disciple_tools' );
                                }
                                ?>
                            </li>
                        </ul>
                        <div class="assigned_to details-edit">
                            <input class="typeahead" type="text" placeholder="<?php esc_html_e( "Type to search users", 'disciple_tools' ) ?>">
                        </div>
                    </div>
                    <!-- Social Media -->
                    <div class="xlarge-4 large-6 medium-6 small-12 cell">
                        <div class="section-subheader"><?php esc_html_e( 'Social Media', 'disciple_tools' ) ?></div>
                        <ul class='social details-list'>
                        <?php
                        $number_of_social = 0;
                        foreach ($contact->fields as $field_key => $values){
                            if ( strpos( $field_key, "contact_" ) === 0 &&
                                strpos( $field_key, "contact_phone" ) === false &&
                                strpos( $field_key, "contact_email" ) === false) {
                                $channel = explode( '_', $field_key )[1];
                                if ( isset( $channel_list[ $channel ] ) ) {
                                    foreach ($values as $value) {
                                        $number_of_social++;
                                        $verified = isset( $value["verified"] ) && $value["verified"] === true ? "inline" :"none";
                                        $invalid = isset( $value["invalid"] ) && $value["invalid"] === true ? "inline" :"none";
                                        ?>
                                        <li class="<?php echo esc_html( $value['key'] )?>">
                                            <?php
                                            if ( $values && sizeof( $values ) > 0 ) {
                                                ?>
                                                <span><?php echo esc_html( $channel_list[ $channel ]["label"] )?>:</span>
                                            <?php } ?>

                                            <span class='social-text'><?php echo esc_html( $value["value"] ) ?></span>
                                            <?php dt_contact_details_status( $value["key"], $verified, $invalid ) ?>
                                        </li>
                                        <?php
                                    }
                                }
                            }
                        }
                        if ($number_of_social === 0 ){
                            ?> <li id="no-social"><?php esc_html_e( 'None set', 'disciple_tools' )?></li> <?php
                        }
                        ?>
                        </ul>
                        <ul class="social details-edit">
                        <?php

                        foreach ($contact->fields as $field_key => $values){
                            if ( strpos( $field_key, "contact_" ) === 0 &&
                                strpos( $field_key, "contact_phone" ) === false &&
                                strpos( $field_key, "contact_email" ) === false) {
                                $channel = explode( '_', $field_key )[1];
                                if ( isset( $channel_list[ $channel ] ) ) {
                                    foreach ($values as $value) {
                                        $verified = isset( $value["verified"] ) && $value["verified"] === true;
                                        $invalid = isset( $value["invalid"] ) && $value["invalid"] === true;
                                        ?>
                                        <li class='<?php echo esc_html( $value['key'] ) ?>'>
                                            <?php
                                            if ( $values && sizeof( $values ) > 0 ) {
                                                ?><span><?php echo esc_html( $channel_list[ $channel ]["label"] )?></span>
                                            <?php } ?>
                                            <input id='<?php echo esc_html( $value["key"] ) ?>' class='details-edit social-input' value='<?php echo esc_html( $value["value"] ) ?>'>
                                            <?php dt_contact_details_edit( $value["key"], "social", true ) ?>
                                        </li>
                                        <?php
                                    }
                                }
                            }
                        }
                        ?>

                        </ul>
                        <div class="details-edit">
                            <label for="social-channels"><?php esc_html_e( 'Add another contact method', 'disciple_tools' )?></label>
                            <select id="social-channels">
                                <?php
                                foreach ($channel_list as $key => $channel){
                                    if ($key != "phone" && $key != "email"){
                                        ?><option value="<?php echo esc_html( $key ) ?>"> <?php echo esc_html( $channel["label"] ) ?></option><?php
                                    }
                                }
                                ?>
                            </select>
                            <div class="new-social-media">
                                <input type="text" id="new-social-media" placeholder="facebook.com/user1">
                                <button id="add-social-media" class="button small loader">
                                    <?php esc_html_e( 'Add', 'disciple_tools' ) ?>
                                </button>
                            </div>
                        </div>



                        <div class="section-subheader"><?php esc_html_e( 'People Groups', 'disciple_tools' )?></div>
                        <ul class="people_groups-list">
                            <?php
                            foreach ($contact->fields["people_groups"] ?? [] as $value){
                                ?>
                                <li class="<?php echo esc_html( $value->ID )?>">
                                    <a href="<?php echo esc_url( $value->permalink ) ?>"><?php echo esc_html( $value->post_title ) ?></a>
                                    <button class="details-remove-button connection details-edit"
                                            data-field="people_groups" data-id="<?php echo esc_html( $value->ID ) ?>"
                                            data-name="<?php echo esc_html( $value->post_title ) ?>">
                                        Remove
                                    </button>
                                </li>
                            <?php }
                            if (sizeof( $contact->fields["people_groups"] ) === 0){
                                ?> <li id="no-people-group"><?php esc_html_e( "No people group set", 'disciple_tools' ) ?></li><?php
                            }
                            ?>
                        </ul>
                        <div class="people-groups details-edit">
                            <input class="typeahead" type="text" placeholder="Type to search people groups">
                        </div>
                    </div>
                </div>


                <div id="show-more-content" class="grid-x grid-margin-x show-content" style="display:none;">
                    <div class="xlarge-4 large-6 medium-6 small-12 cell">
                        <div class="section-subheader"><?php esc_html_e( 'Address', 'disciple_tools' )?>
                            <button id="add-new-address" class="details-edit">
                                <img src="<?php echo esc_html( get_template_directory_uri() . '/assets/images/small-add.svg' ) ?>"/>
                            </button>
                        </div>
                        <ul class="address details-list">
                            <?php
                            if (sizeof( $contact->fields["address"] ?? [] ) === 0 ){
                                ?> <li id="no-address"><?php esc_html_e( "No address set", 'disciple_tools' ) ?></li> <?php
                            }
                            foreach ($contact->fields["address"] ?? [] as $value){
                                $verified = isset( $value["verified"] ) && $value["verified"] === true ? "inline" :"none";
                                $invalid = isset( $value["invalid"] ) && $value["invalid"] === true ? "inline" :"none";
                                ?>
                                <li class="<?php echo esc_html( $value["key"] ) ?> address-row">
                                    <div class="address-text"><?php echo esc_html( $value["value"] );?></div><?php dt_contact_details_status( $value["key"], $verified, $invalid ) ?>
                                </li>
                            <?php } ?>
                        </ul>
                        <ul id="address-list" class="details-edit">
                        <?php
                        if ( isset( $contact->fields["address"] )){
                            foreach ($contact->fields["address"] ?? [] as $value){
                                $verified = isset( $value["verified"] ) && $value["verified"] === true;
                                $invalid = isset( $value["invalid"] ) && $value["invalid"] === true;
                                ?>
                                <div class="<?php echo esc_attr( $value["key"], 'disciple_tools' )?>">
                                    <textarea rows="3" id="<?php echo esc_attr( $value["key"], 'disciple_tools' )?>"><?php echo esc_attr( $value["value"], 'disciple_tools' )?></textarea>
                                    <?php dt_contact_details_edit( $value["key"], "address", true ) ?>
                                </div>
                                <hr>

                            <?php }
                        }?>
                        </ul>
                    </div>

                    <div class="xlarge-4 large-6 medium-6 small-12 cell">
                        <div class="section-subheader"><?php esc_html_e( 'Age', 'disciple_tools' )?>:</div>
                        <ul class="details-list">
                            <li class="current-age">
                                <?php
                                if ( isset( $contact->fields['age']['label'] ) ){
                                    echo esc_html( $contact->fields['age']['label'] );
                                } else {
                                    esc_html_e( 'No age set', 'disciple_tools' );
                                }
                                ?>
                            </li>
                        </ul>
                        <select id="age" class="details-edit select-field">
                            <?php
                            foreach ( $contact_fields["age"]["default"] as $age_key => $age_value ) {
                                if ( isset( $contact->fields["age"] ) &&
                                    $contact->fields["age"]["key"] === $age_key){
                                    echo '<option value="'. esc_html( $age_key ) . '" selected>' . esc_html( $age_value ) . '</option>';
                                } else {
                                    echo '<option value="'. esc_html( $age_key ) . '">' . esc_html( $age_value ). '</option>';

                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="xlarge-4 large-6 medium-6 small-12 cell">
                        <div class="section-subheader"><?php esc_html_e( 'Gender', 'disciple_tools' )?>:</div>
                        <ul class="details-list">
                            <li class="current-gender">
                                <?php
                                if ( isset( $contact->fields['gender']['label'] ) ){
                                    echo esc_html( $contact->fields['gender']['label'] );
                                } else {
                                    esc_html_e( 'No gender set', 'disciple_tools' );
                                }
                                ?>
                        </ul>
                        <select id="gender" class="details-edit select-field">
                            <?php
                            foreach ( $contact_fields["gender"]["default"] as $gender_key => $gender_value ) {
                                if ( isset( $contact->fields["gender"] ) &&
                                    $contact->fields["gender"]["key"] === $gender_key){
                                    echo '<option value="'. esc_html( $gender_key ) . '" selected>' . esc_html( $gender_value ) . '</option>';
                                } else {
                                    echo '<option value="'. esc_html( $gender_key ) . '">' . esc_html( $gender_value ). '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="xlarge-4 large-6 medium-6 small-12 cell">
                        <div class="section-subheader"><?php esc_html_e( "Source" ); ?></div>
                        <ul class="details-list">
                            <li class="current-sources">
                                <?php
                                if (isset( $contact->fields["sources"] )) {
                                    echo esc_html( $contact->fields["sources"]["label"] );
                                } else {
                                    esc_html_e( "No source set" );
                                }
                                ?>
                            </li>
                        </ul>
                        <select id="sources" class="details-edit select-field">
                            <option value=""></option>
                            <?php
                            foreach ( $custom_lists["sources"] as $sources_key => $sources_value ) {
                                if ( isset( $contact->fields["sources"] ) &&
                                    $contact->fields["sources"]["key"] === $sources_key){
                                    echo '<option value="'. esc_html( $sources_key ) . '" selected>' . esc_html( $sources_value["label"] ) . '</option>';
                                } else {
                                    echo '<option value="'. esc_html( $sources_key ) . '">' . esc_html( $sources_value["label"] ). '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row show-more-button" style="text-align: center" >
                    <button class="clear show-button"  href="#"><?php esc_html_e( 'Show', 'disciple_tools' )?>
                        <span class="show-content show-more"><?php esc_html_e( 'more', 'disciple_tools' )?> <img src="<?php echo esc_html( get_template_directory_uri() . '/assets/images/chevron_down.svg' )?>"/></span>
                        <span class="show-content" style="display:none;"><?php esc_html_e( 'less', 'disciple_tools' )?> <img src="<?php echo esc_html( get_template_directory_uri() . '/assets/images/chevron_up.svg' )?>"></span>
                    </button>
                </div>
            </div>
        </div>
    </section>

<?php
})();


