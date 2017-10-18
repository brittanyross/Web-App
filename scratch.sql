/* query that grabs a person's classes for the past month and also grabs person's details to bring up in more details panel */




/* Using the teacher's(facilitator's) logon id, get a list of the last classes they held */
select fca.topicname, fca.date
from facilitators f, facilitatorclassattendance fca, employees e
where e.employeeid = f.facilitatorid
      and f.facilitatorid = fca.facilitatorid
      and f.facilitatorid = 5
order by fca.date asc
limit 20;
/* end */

/* display class attendance */

/*

Give info of participants who are in a specific curricula and
a specific class, with a specific facilitator and
who have shown up in the past 3 weeks (of that specific class,
curricula, and person) and who hasn't completed the curricula
(aka has missed less than or equal to 2 classes)

 */

select
  people.firstname,
  people.lastname,
  participants.dateofbirth,
  forms.addressid,
  count(children.childrenid)

from
  classes,
  curricula,
  facilitatorclassattendance,
  classoffering,
  participantclassattendance,
  participants,
  people,

  /* zip code related */
  participantsformdetails,
  forms,
  addresses,
  /* number of children under 18 */
  familymembers,
  children

/* general linking */
where  people.peopleid = participants.participantid
       and    participants.participantid = participantclassattendance.participantid
       and    participantclassattendance.topicname = classoffering.topicname
       and    participantclassattendance.sitename = classoffering.sitename
       and    classoffering.topicname = facilitatorclassattendance.topicname
       and    classoffering.sitename = facilitatorclassattendance.sitename
       and    classoffering.topicname = classes.topicname
       and    classoffering.curriculumid = curricula.curriculumid

       /* zip code linking */
       and participants.participantid = participantsformdetails.participantid
       and participantsformdetails.formid = forms.formid
       and forms.formid = addresses.addressid

       /* num children under 18 linking */
       and people.peopleid = familymembers.familymemberid
       and familymembers.familymemberid = children.childrenid


       /* class specific information */
       and    classoffering.topicname = 'How to be a good parent'
       and    facilitatorclassattendance.facilitatorid = 5;



/* end display class attendance*/

select * from classoffering;

select * from participantclassattendance;

select * from employees;

select * from facilitators;

select * from facilitatorclassattendance;

select * from children;