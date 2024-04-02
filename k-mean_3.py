import random
from sklearn.cluster import KMeans
from flask import Flask, jsonify, request
import numpy as np
import json

app = Flask(__name__)

@app.route('/getgroups', methods=['GET'])
def create_groups():
    if 'num_students' in request.args and request.args['num_students'] != '':
        num_students = int(request.args['num_students'])
    else:
        return "Error: No num_students field provided. Please specify an num_students."
    
    if(request.data):
        data_ratio = request.get_json()
        ratios = data_ratio['ratio']
    else:
         return "Error: No ratios field provided. Please specify an ratios."      
      
    students =  [(i, f"Student {i+1}") for i in range(num_students)]
    data = [(ratio, student[1], student[0]) for ratio, student in zip(ratios, students)]
    
    if 'num_groups' in request.args and request.args['num_groups'] != '':
        num_groups = int(request.args['num_groups'])
    else:
        return "Error: No num_groups field provided. Please specify an num_groups."
    if 'group_size' in request.args and request.args['group_size'] != '':
        group_size = int(request.args['group_size'])
    else:
        return "Error: No group_size field provided. Please specify an group_size."    
    if 'group_preference' in request.args and request.args['group_preference'] != '':
        group_preference = request.args['group_preference']
    else:
        return "Error: No group_preference field provided. Please specify an group_preference."          
           
    
    if group_preference.lower() == "similar":
        kmeans = KMeans(n_clusters=num_groups, random_state=42)
        kmeans.fit(np.array(ratios).reshape(-1, 1))
        labels = kmeans.labels_
    else:
        # Shuffle the ratios to get random initial clusters
        random.shuffle(ratios)
        initial_clusters = np.array(ratios[:num_groups]).reshape(-1, 1)
        kmeans = KMeans(n_clusters=num_groups, random_state=42, init=initial_clusters)
        kmeans.fit(np.array(ratios).reshape(-1, 1))
        labels = kmeans.labels_
    
    groups = [[] for _ in range(num_groups)]
    assigned_students = set()

    for i, label in enumerate(labels):
        group_data = (data[i][0], data[i][1], data[i][2])
        if data[i][2] not in assigned_students:
            groups[label].append(group_data)
            assigned_students.add(data[i][2])
    
    num_leftover = num_students % group_size
    if num_leftover > 0:
        leftover_students = [data[i] for i in range(num_students - num_leftover, num_students)]
        random.shuffle(leftover_students)
    
    while any([len(group) < group_size for group in groups]):
     for i, group in enumerate(groups):
        if len(group) < group_size:
            for j, other_group in enumerate(groups):
                if i != j and len(other_group) > group_size:
                    student_to_move = other_group.pop()
                    groups[i].append(student_to_move)
                    break
            else:
                if leftover_students:
                    groups[i].append(leftover_students.pop())
                else:
                    unassigned_students = [s for s in data if s[2] not in assigned_students]
                    if unassigned_students:
                        student_to_add = random.choice(unassigned_students)
                        groups[i].append(student_to_add)
                        assigned_students.add(student_to_add[2])
                    
    while any([len(group) < group_size for group in groups]):
     for i, group in enumerate(groups):
        if len(group) < group_size:
            for j, other_group in enumerate(groups):
                if i != j and len(other_group) > group_size:
                    student_to_move = other_group.pop()
                    groups[i].append(student_to_move)
                    break
            else:
                if leftover_students:
                    groups[i].append(leftover_students.pop())
                else:
                    unassigned_students = [s for s in data if s[2] not in assigned_students]
                    if unassigned_students:
                        student_to_add = random.choice(unassigned_students)
                        groups[i].append(student_to_add)
                        assigned_students.add(student_to_add[2])

    result = []
    for group  in groups:
          result.append([student[0] for student in group])
    return result
if __name__ == "__main__":
 app.run()

