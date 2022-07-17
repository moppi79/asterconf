<?php
error_reporting(-1);
ini_set("display_errors",1);

$db_user = '';
$db_pw = '';


$verzeichniss = 'peer/'; //hier sind die daten Tempolrär gelagert und werden dann nach /etc/asterisk/peer kopiert  

$path_asterconf = "/net/html/new_asterconf/"; //verzeichniss HTML Asterisk Config

$mysqli = new mysqli("localhost", $db_user, $db_pw, "asterconf");  //mysqli Create


#>>>>>>>> WICHTIG ... damit die Externe Datei in den asterisk geladen wird 
#>>>>>>>> WICHTIG ... musss der satz an das ende der extensions.conf
#>>>>>>>> WICHTIG ... #include php_dailplan.conf ;der # muss zwingend vor dem include sein


##################################################################################################################################################

$app_array = array('Set','System','SIPAddHeader','Return','dial','Answer','Hangup','WaitExten','Set','NoOp','GotoIf','Goto','Background','Playback','VoiceMail','VoiceMailMain','GotoIfTime','MusicOnHold','ConfBridge');

function del_arry ($mysqli){

    $t = '';
    if ($result = $mysqli->query("SELECT * FROM Deleted_ID ")) { //bereitstellen von den gelöschen zeilen
    
        while($obj = $result->fetch_object()){ 
            #print_r($obj);
            if ($t != ''){
            $t .= ",".$obj->Del_ID;
                
            }else{
                $t .= $obj->Del_ID;
                
            }
            
            
        }
        $del_arr1 = explode(',',$t);
         return(array_flip($del_arr1));
    }
}
$del_arr = del_arry($mysqli);

$config_array = array(); 

$config_array['endpoint'] = array("100rel","aggregate_mwi","allow","allow_overlap","aors","auth","callerid","callerid_privacy","callerid_tag","context","direct_media_glare_mitigation","direct_media_method","trust_connected_line","send_connected_line","connected_line_method","direct_media","disable_direct_media_on_nat","disallow","dtmf_mode","media_address","bind_rtp_to_media_address","force_rport","ice_support","identify_by","redirect_method","mailboxes","mwi_subscribe_replaces_unsolicited","voicemail_extension","moh_suggest","outbound_auth","outbound_proxy","rewrite_contact","rtp_ipv6","rtp_symmetric","send_diversion","send_history_info","send_pai","send_rpid","rpid_immediate","timers_min_se","timers","timers_sess_expires","transport","trust_id_inbound","trust_id_outbound","use_ptime","use_avpf","force_avp","media_use_received_transport","media_encryption","media_encryption_optimistic","g726_non_standard","inband_progress","call_group","pickup_group","named_call_group","named_pickup_group","device_state_busy_at","t38_udptl","t38_udptl_ec","t38_udptl_maxdatagram","fax_detect","fax_detect_timeout","t38_udptl_nat","t38_udptl_ipv6","t38_bind_udptl_to_media_address","tone_zone","language","one_touch_recording","record_on_feature","record_off_feature","rtp_engine","allow_transfer","user_eq_phone","moh_passthrough","sdp_owner","sdp_session","tos_audio","tos_video","cos_audio","cos_video","allow_subscribe","sub_min_expiry","from_user","mwi_from_user","from_domain","dtls_verify","dtls_rekey","dtls_auto_generate_cert","dtls_cert_file","dtls_private_key","dtls_cipher","dtls_ca_file","dtls_ca_path","dtls_setup","dtls_fingerprint","srtp_tag_32","set_var","message_context","accountcode","preferred_codec_only","rtp_keepalive","rtp_timeout","rtp_timeout_hold","acl","deny","permit","contact_acl","contact_deny","contact_permit","subscribe_context","contact_user","asymmetric_rtp_codec","rtcp_mux","refer_blind_progress","notify_early_inuse_ringing","max_audio_streams","max_video_streams","bundle","webrtc","incoming_mwi_mailbox","follow_early_media_fork","accept_multiple_sdp_answers","suppress_q850_reason_headers","ignore_183_without_sdp","stir_shaken","stir_shaken_profile","allow_unauthenticated_options");

$config_array['auth'] = array("auth_type","nonce_lifetime","md5_cred","password","realm","username");

$config_array['aor'] = array("contact","default_expiration","mailboxes","voicemail_extension","maximum_expiration","max_contacts","minimum_expiration","remove_existing","remove_unavailable","qualify_frequency","qualify_timeout","authenticate_qualify","outbound_proxy","support_path");

$config_array['contact'] = array("uri","expiration_time","qualify_frequency","qualify_timeout","authenticate_qualify","outbound_proxy","path","user_agent","endpoint","reg_server","via_addr","via_port","call_id","prune_on_boot");

$config_array['transport'] = array("async_operations","bind","ca_list_file","ca_list_path","cert_file","cipher","domain","external_media_address","external_signaling_address","external_signaling_port","method","local_net","password","priv_key_file","protocol","require_client_cert","verify_client","verify_server","tos","cos","websocket_write_timeout","allow_reload","symmetric_transport");

$config_array['system'] = array("max_forwards","keep_alive_interval","contact_expiration_check_interval","disable_multi_domain","max_initial_qualify_time","unidentified_request_period","unidentified_request_count","unidentified_request_prune_interval","user_agent","regcontext","default_outbound_endpoint","default_voicemail_extension","debug","endpoint_identifier_order","default_from_user","default_realm","mwi_tps_queue_high","mwi_tps_queue_low","mwi_disable_initial_unsolicited","ignore_uri_user_options","use_callerid_contact","send_contact_status_on_update_registration","taskprocessor_overload_trigger","norefersub","allow_sending_180_after_183");

$config_array['global'] = array("allow_sending_180_after_183","contact_expiration_check_interval","debug","default_from_user","default_outbound_endpoint","default_realm","default_voicemail_extension","disable_multi_domain","endpoint_identifier_order","ignore_uri_user_options","keep_alive_interval","max_forwards","max_initial_qualify_time","mwi_disable_initial_unsolicited","mwi_tps_queue_high","mwi_tps_queue_low","norefersub","regcontext","send_contact_status_on_update_registration","taskprocessor_overload_trigger","unidentified_request_count","unidentified_request_period","unidentified_request_prune_interval","use_callerid_contact","user_agent");

$config_array['registration'] = array("auth_rejection_permanent","client_uri","contact_user","expiration","max_retries","outbound_auth","outbound_proxy","retry_interval","forbidden_retry_interval","fatal_retry_interval","server_uri","transport","line","endpoint","type","support_path");

$config_array['identify'] = array("endpoint","match","srv_lookups","match_header");

$config_array['resource_list'] = array("event","list_item","full_state","notification_batch_interval","resource_display_name");

$config_array['inbound-publication'] = array("endpoint");

//$config_array[''] = array();
?>