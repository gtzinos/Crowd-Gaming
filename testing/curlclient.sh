#!/bin/bash

echo "Crowd Gaming Console Client . Version 0.1"
echo

TOKEN="58aac496041d8a2814dc9eaef6716900bec90e71"
URL="crowd-gaming.local"

#curl --header "Authorization: $TOKEN" crowd-gaming.local/rest_api/questionnaire

case $1 in
	"authenticate" )

		curl --data '{ "email":"'$2'" , "password":"'$3'" }' $URL/rest_api/authenticate | python -m json.tool ;;
	
	"questionnaire" )

		curl --header "Authorization: $TOKEN" $URL/rest_api/questionnaire/$2 | python -m json.tool;;

	"question-group" )
	
		curl --header "Authorization: $TOKEN" $URL/rest_api/questionnaire/$2/group/$3 | python -m json.tool;;

	"question" )

		curl --header "Authorization: $TOKEN" $URL/rest_api/questionnaire/$2/group/$3/question  | python -m json.tool;;
	
	"reset-group" )

		curl --header "Authorization: $TOKEN" $URL/rest_api/questionnaire/$2/group/$3/reset | python -m json.tool;;

	"answer" )
	
		curl --header "Authorization: $TOKEN" --data '{ "question-id":"'$2'" , "answer-id":"'$3'" }' $URL/rest_api/answer | python -m json.tool;;

	"post-report" )

		curl --header "Authorization: $TOKEN" --data '{ "questionnaire-id":"'$2'" , "report-comment":"'$3'" }' $URL/rest_api/report  ;; #| python -m json.tool ;;
	"score" )

		curl --header "Authorization: $TOKEN" $URL/rest_api/questionnaire/$2/score | python -m json.tool ;;

	"help" )
		
		echo Valid parameters
		echo 
		echo authenticate 	:email 				:password
		echo questionnaire 	:id
		echo question-group :questionnaire-id 	:group-id
		echo question 		:questionnaire-id 	:group-id
		echo answer 		:question-id 		:answer-id
		echo reset-group 	:questionnaire-id 	:group-id
		echo post-report 	:questionnaire-id 	:report-comment
		;;
esac

echo