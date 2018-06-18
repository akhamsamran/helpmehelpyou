# helpmehelpyou
a "concurrence" is the point where three lines intersect.  
In the case of helpmehelpyou, it is the place where people's intentions, locations and times come into
alignment in order to allow people to help each other.
What if there was an app where you could enter what you needed, where and when, 
and this could be matched to other people to create an environment in which people could 
conveniently offer their help.
Imagine if on your map or calendar there were points that showed where other people's needs would 
intersect with your regular daily activities.  
If you were on your way to work, you would be able to see who needed a ride in the same direction.  
If you needed a babysitter, others could see if their schedules would allow them to help.
For people who want to help people in their neighborhood and beyond, it would allow them to easily
identify where help was needed and when, and even allow help while carrying on as usual with their 
own daily activities, without any special trips or detours. Sort of like allowing a remora to catch
a free ride on a shark.
For a first iteration, the app could simply be a ride-sharing app.  For future iterations, it could be 
updated to allow for people to advertise and accept services. (a sort of fusion between an Angie's List
, a neighbor app, and something like twitter)

Questions:
get by post start?, get by post location? is this necessary, or not? if not, how do I do searches by start time?, 
by location(use lat, long or distance or address?? just through sorting?

*****>>>>>SHould I add an attribute to Post that is similar to category, which is pre-set general areas to 
assist with searching by location, since lat/long and addresses are too specific?<<<<<*****

Would it be better to just do 1 table for the posts and allow people to search by location or time or type?  
What is the best way to find concurrences? It has to be a 3-way sort: location/time/type.  
All three from one person
must match the three from another person for the concurrence to be identified.
A calendar app is great for time and type.
A map app is great for location and type.
What would allow for interaction between these? 
It is 3-dimensional, so what does it look like? How would it be best displayed for usefulness?

QUESTIONS TO for Post Structure:
Do I want to store start and end times in a different table? 
	MAYBE because both start and end times are the same type of data. 
		DATE, TIME, DATETIME, TIMESTAMP, and YEAR. SHould I separate it further into date, time and year? 
		This would allow for more types of searches and better sorting, but more attributes to deal with.
		Timestamp can only be used once in a table?, but it changes every time you access it. 
		can I store both the date and time in the same field, or should I separate them? yes you can store in DateTime, but less easy to sort? maybe, maybe not.
Do I want to store lat and long in a different table? 
	NO because lat and long are different and can be unique to each Post object.
