#!/bin/bash

echo "==================================="
echo "Crowd Gaming Console Client"
echo "==================================="

TOKEN="d8f2fe1b831977bec8aea8a73b6a4bd23a701099"
URL="crowd-gaming.local"

#curl --header "Authorization: $TOKEN" crowd-gaming.local/rest_api/questionnaire

case $1 in
	"authenticate" )

		curl --data '{ "email":"'$2'" , "password":"'$3'" }' $URL/rest_api/authenticate ;; #| python -m json.tool ;;
	
	"questionnaire" )

		curl --header "Authorization: $TOKEN" $URL/rest_api/questionnaire/$2 ;; #| python -m json.tool;;

	"question-group" )
	
		curl --header "Authorization: $TOKEN" $URL/rest_api/questionnaire/$2/group/$3 ;; #| python -m json.tool;;

	"question" )

		curl --header "Authorization: $TOKEN" $URL/rest_api/questionnaire/$2/group/$3/question ;; #| python -m json.tool;;
	
	"reset-group" )

		curl --header "Authorization: $TOKEN" $URL/rest_api/questionnaire/$2/group/$3/reset ;; # | python -m json.tool;;

	"answer" )
	
		curl --header "Authorization: $TOKEN" --data '{ "question-id":"'$2'" , "answer-id":"'$3'" }' $URL/rest_api/answer ;; # | python -m json.tool;;

esac

echo
echo "==================================="
echo "Request End"
echo "==================================="